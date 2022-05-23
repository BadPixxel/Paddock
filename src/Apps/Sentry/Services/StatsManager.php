<?php

/*
 *  Copyright (C) BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Paddock\Apps\Sentry\Services;

use Exception;
use Throwable;

class StatsManager
{
    /**
     * Get Statistics from API Stats V1
     *
     * @param array $config
     *
     * @throws Throwable
     *
     * @return null|int
     */
    public function getReceivedLastHourV1(array $config): ?int
    {
        //====================================================================//
        // Execute API V1 Request
        $start = new \DateTime("-1 hour");
        $end = new \DateTime("");
        $response = $this->getFromApi(
            $config,
            sprintf("/organizations/%s/stats/", $config['organization']),
            array(
                "stat" => "received",
                "since" => $start->getTimestamp(),
                "until" => $end->getTimestamp(),
                "resolution" => "1h",
            )
        );
        //====================================================================//
        // Safety Check
        if (!$response || !is_array($values = json_decode($response, true))) {
            return null;
        }
        //====================================================================//
        // Sum results
        $total = 0;
        foreach ($values as $value) {
            $total += $value[1] ?? 0;
        }

        return (int) $total;
    }

    /**
     * Get Statistics from API Stats V2
     *
     * @param array $config
     *
     * @throws Exception
     *
     * @return null|int
     */
    public function getLastHourErrors(array $config, ?string $type = null): ?int
    {
        //====================================================================//
        // Build Query Parameters
        $query = array(
            "field" => "sum(quantity)",
            "statsPeriod" => $config['period'],
            "interval" => $config['period'],
            "groupBy" => "outcome",
            "category" => "error",
        );
        if ($type) {
            $query = array_merge_recursive($query, array("outcome" => $type));
        }
        //====================================================================//
        // Execute API Request
        $response = $this->getFromApi(
            $config,
            sprintf("/organizations/%s/stats_v2/", $config['organization']),
            $query
        );
        //====================================================================//
        // Safety Check
        if (!$response || !is_array($values = json_decode($response, true))) {
            return null;
        }
        //====================================================================//
        // Sum Results
        $total = 0;
        foreach ($values['groups'] ?? array() as $value) {
            $total += array_sum($value["totals"] ?? array());
        }

        return (int) $total;
    }

    /**
     * Init Stats Manager with Collector Config
     *
     * @param array  $config
     * @param string $url
     * @param array  $query
     *
     * @throws Exception
     *
     * @return string
     */
    private function getFromApi(array $config, string $url, array $query = array()): string
    {
        //====================================================================//
        // Build Final Url
        $uri = $this->getApiEndpoint($config, $url);
        if (!empty($query)) {
            $uri .= "?".http_build_query($query);
        }
        //====================================================================//
        // Execute Curl Request
        $curl = curl_init();

        try {
            curl_setopt($curl, CURLOPT_URL, $uri);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$config['token'],
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            $response = (string)  curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_code != intval(200)) {
                curl_close($curl);

                throw new Exception($response);
            }
        } catch (Exception $ex) {
            throw $ex;
        } finally {
            curl_close($curl);
        }

        return $response;
    }

    /**
     * Get Sentry Api Endpoint
     *
     * @param array  $config
     * @param string $suffix
     *
     * @return string
     */
    private function getApiEndpoint(array $config, string $suffix): string
    {
        $requestUrl = parse_url($config['url'], PHP_URL_SCHEME)."://";
        $requestUrl .= parse_url($config['url'], PHP_URL_HOST);
        $requestUrl .= parse_url($config['url'], PHP_URL_PATH);
        if ($suffix) {
            $requestUrl .= $suffix;
        }

        return $requestUrl;
    }
}

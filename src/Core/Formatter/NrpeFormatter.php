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

namespace BadPixxel\Paddock\Core\Formatter;

use BadPixxel\Paddock\Core\Models\Formatter\AbstractFormatter;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Response;

/**
 * Paddock Nrpe Results Formatter
 */
class NrpeFormatter extends AbstractFormatter
{
    /** NRPE STATE OK */
    const OK = 0;

    /** NRPE STATE WARNING */
    const WARNING = 1;

    /** NRPE STATE ERROR */
    const ERROR = 2;

    /** NRPE STATE UNKNOWN */
    const UNKNOWN = 3;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $warnings;

    /**
     * Get Response Status Code
     */
    public function getStatusCode(): int
    {
        if (!empty($this->errors)) {
            return 2;
        }
        if (!empty($this->warnings)) {
            return 1;
        }

        return 0;
    }

    /**
     * Get Results Status String
     */
    public function getStatus(): string
    {
        if ($this->errors) {
            return sprintf(
                "CRITICAL: %d Errors detected. %s %s",
                count($this->errors),
                implode(", ", $this->errors),
                $this->getMetrics()
            );
        }
        if ($this->warnings) {
            return sprintf(
                "WARNING: %d Warnings detected. %s %s",
                count($this->warnings),
                implode(", ", $this->warnings),
                $this->getMetrics()
            );
        }

        return "All OK !!".$this->getMetrics();
    }

    /**
     * Get Results as Symfony Response
     */
    public function getResponse(): Response
    {
        return new Response(
            $this->getStatus(),
            !empty($this->errors) ? Response::HTTP_EXPECTATION_FAILED: Response::HTTP_OK
        );
    }

    /**
     * Analyze Records
     */
    protected function parse(): void
    {
        //====================================================================//
        // Count Numbers of Errors & Warnings
        $this->errors = $this->warnings = array();
        foreach ($this->records as $record) {
            if ($record['level'] >= Logger::ERROR) {
                $this->errors[] = $record["message"];

                continue;
            }
            if ($record['level'] >= Logger::WARNING) {
                $this->warnings[] = $record["message"];
            }
        }
    }

    /**
     * Output Logger Metrics
     *
     * @return string
     */
    private function getMetrics(): string
    {
        //====================================================================//
        // No Statistics
        if (empty($this->counters)) {
            $this->counters["errors"] = count($this->errors);
            $this->counters["warnings"] = count($this->warnings);
        }
        //====================================================================//
        // Outputs Statistics
        $metrics = " | ";
        foreach ($this->counters as $name => $counter) {
            //====================================================================//
            // Outputs Statistics
            $metrics .= sprintf("'%s'=%s%s", $name, (string) $counter, $this->getMetricOptions($name));
        }

        return $metrics;
    }

    /**
     * Output Logger Metrics Options
     *
     * @param string $name
     *
     * @return string
     */
    private function getMetricOptions(string $name): string
    {
        //====================================================================//
        // Safety Check
        if (!isset($this->options[$name]) || !is_array($this->options[$name])) {
            return ";";
        }
        //====================================================================//
        // Build Nagios/NRPE Metric Options
        $options = str_replace("P", "%", $this->options[$name]['uom'] ?? "").";";
        $options .= ($this->options[$name]['warn'] ?? "").";";
        $options .= ($this->options[$name]['crit'] ?? "").";";
        $options .= ($this->options[$name]['min'] ?? "").";";
        $options .= ($this->options[$name]['max'] ?? "");

        return $options;
    }
}

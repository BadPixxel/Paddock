<?php

/*
 *  Copyright (C) 2021 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Paddock\Backup\Helpers;

use DateTime;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class StatusStorage
{
    /**
     * Check if Backup is Success
     *
     * @param string        $operationCode
     * @param string        $location
     * @param null|DateTime $maxDate
     *
     * @return bool
     */
    public static function isSuccessful(string $operationCode, string $location, DateTime $maxDate = null): bool
    {
        //====================================================================//
        // Status Exists for this Backup
        $status = self::getCache($operationCode."::".$location);
        if (!is_array($status)) {
            return false;
        }
        //====================================================================//
        // Status is KO
        if (empty($status["successful"])) {
            return false;
        }
        //====================================================================//
        // Status is Outdated
        if (!empty($maxDate) && ($maxDate > $status["lastSuccess"])) {
            return false;
        }

        return true;
    }

    /**
     * Check if Backup is Success
     *
     * @param string $operationCode
     * @param string $location
     *
     * @return null|array
     */
    public static function getStatus(string $operationCode, string $location): ?array
    {
        $status = self::getCache($operationCode."::".$location);

        return is_array($status) ? $status : null;
    }

    /**
     * Store Backup results on Success
     *
     * @param string $operationCode
     * @param string $location
     * @param string $log
     *
     * @return true
     */
    public static function onSuccess(string $operationCode, string $location, string $log): bool
    {
        self::setCache($operationCode."::".$location, array(
            "successful" => true,
            "code" => $operationCode,
            "lastChange" => new DateTime(),
            "lastSuccess" => new DateTime(),
            "log" => $log,
        ));

        return true;
    }

    /**
     * Store Backup results on Errors
     *
     * @param string $operationCode
     * @param string $log
     *
     * @return false
     */
    public static function onError(string $operationCode, string $location, string $log): bool
    {
        self::setCache($operationCode."::".$location, array(
            "successful" => false,
            "code" => $operationCode,
            "lastChange" => new DateTime(),
            "lastError" => new DateTime(),
            "log" => $log,
        ));

        return false;
    }

    /**
     * Get cache Adapter
     *
     * @return FilesystemAdapter
     */
    private static function getAdapter(): FilesystemAdapter
    {
        static $adapter;

        if (!isset($adapter)) {
            $adapter = new FilesystemAdapter("PaddockBkpStatus");
        }

        return $adapter;
    }

    /**
     * Get Cached Result
     *
     * @param string $key
     *
     * @return null|array
     */
    private static function getCache(string $key): ?array
    {
        try {
            /** @var ItemInterface $item */
            $item = self::getAdapter()->getItem(md5($key));
        } catch (InvalidArgumentException $e) {
            return null;
        }
        $value = $item->get();

        return is_array($value) ? $value : null;
    }

    /**
     * Get Cached Result
     *
     * @param string $key
     * @param array  $value
     *
     * @return void
     */
    private static function setCache(string $key, array $value): void
    {
        try {
            /** @var ItemInterface $item */
            $item = self::getAdapter()->getItem(md5($key));
        } catch (InvalidArgumentException $e) {
            return;
        }
        $current = $item->get();
        $item->set(array_replace_recursive(
            is_array($current) ? $current : array(),
            $value
        ));
        self::getAdapter()->save($item);
    }
}

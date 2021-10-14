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

/**
 * Simply Convert Url to Provider types & options
 */
class UrlParser
{
    /**
     * Extract Type from Configuration Path
     *
     * @param string $path
     *
     * @return null|string
     */
    public static function toType(string $path): ?string
    {
        return parse_url($path, PHP_URL_SCHEME) ?: null;
    }

    /**
     * Extract Options from Configuration Path
     *
     * @param string $path
     *
     * @return array
     */
    public static function toOptions(string $path): array
    {
        $parsed = parse_url($path);
        if (!is_array($parsed)) {
            return array();
        }
        if (isset($parsed['scheme'])) {
            unset($parsed['scheme']);
        }

        return $parsed;
    }
}

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

namespace BadPixxel\Paddock\Core\Formatter;

use Monolog\Formatter\JsonFormatter as BaseFormatter;

/**
 * Class JsonFormatter
 */
class JsonFormatter extends BaseFormatter
{
    /**
     * {@inheritdoc}
     */
    public function normalize($data, int $depth = 0)
    {
        $normalized = parent::normalize($data, $depth);

        if (1 == $depth) {
            unset($normalized["datetime"], $normalized["level"], $normalized["level_name"], $normalized["channel"], $normalized["extra"], $normalized["formatted"]);

//            dump($normalized);
//            exit;
        }

        return $normalized;
    }
}
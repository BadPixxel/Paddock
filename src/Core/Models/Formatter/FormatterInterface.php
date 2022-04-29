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

namespace BadPixxel\Paddock\Core\Models\Formatter;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface for Paddock Results Formatters
 */
interface FormatterInterface
{
    /**
     * Get Response Status Code
     */
    public function getStatusCode(): int;

    /**
     * Get Results Status String
     */
    public function getStatus(): string;

    /**
     * Get Results as Symfony Response
     */
    public function getResponse(): Response;
}

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

    /**
     * @var int
     */
    private $errors;

    /**
     * @var int
     */
    private $warnings;

    /**
     * Get Response Status Code
     */
    public function getStatusCode(): int
    {
        if ($this->errors) {
            return 2;
        }
        if ($this->warnings) {
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
            return sprintf("CRITICAL: %d Errors detected (%d Warnings)", $this->errors, $this->warnings);
        }
        if ($this->warnings) {
            return sprintf("WARNING: %d Warnings detected", $this->warnings);
        }

        return "OK";
    }

    /**
     * Get Results as Symfony Response
     */
    public function getResponse(): Response
    {
        return new Response($this->getStatus(), $this->errors ? Response::HTTP_EXPECTATION_FAILED: Response::HTTP_OK);
    }

    /**
     * Analyze Records
     */
    protected function parse(): void
    {
        //====================================================================//
        // Count Numbers of Errors & Warnings
        $this->errors = $this->warnings = 0;
        foreach ($this->records as $record) {
            if ($record['level'] >= Logger::ERROR) {
                $this->errors++;

                continue;
            }
            if ($record['level'] >= Logger::WARNING) {
                $this->warnings++;
            }
        }
    }
}

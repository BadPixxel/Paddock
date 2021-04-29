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

namespace BadPixxel\Paddock\Core\Models\Formatter;

use Exception;

/**
 * Abstract Paddock Results Formatter
 */
abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * @var array
     */
    protected $records;

    /**
     * @param array $records
     *
     * @throws Exception
     */
    public function __construct(array $records)
    {
        $this->records = $records;

        $this->parse();
    }

    /**
     * Analyze Records
     *
     * @throws Exception
     */
    protected function parse(): void
    {
        throw new Exception("No Parser Implemented...");
    }
}
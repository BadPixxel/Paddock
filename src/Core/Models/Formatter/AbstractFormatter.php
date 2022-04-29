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
     * @var array<string, int>
     */
    protected $counters;

    /**
     * @var array<string, array>
     */
    protected $options;

    /**
     * @param array $records
     * @param array $counters
     * @param array $options
     *
     * @throws Exception
     */
    public function __construct(array $records, array $counters, array $options = array())
    {
        $this->records = $records;
        $this->counters = $counters;
        $this->options = $options;

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

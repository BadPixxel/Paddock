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

namespace BadPixxel\Paddock\Core\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Paddock Local Handler.
 *
 * It records all records and gives you access to them for verification.
 */
class LocalHandler extends AbstractProcessingHandler
{
    /**
     * @var array[]
     */
    protected $records = array();

    /**
     * @var array
     */
    protected $recordsByLevel = array();

    /**
     * @var int
     */
    protected $maxLevel = 0;

    /**
     * Get All records
     *
     * @return array[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * Reset Handler | Clear All Logs
     *
     * @return void
     */
    public function reset()
    {
        $this->records = array();
        $this->recordsByLevel = array();
    }

    /**
     * Check if Loger Has Errors
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->maxLevel >= Logger::ERROR;
    }

    /**
     * Check if Loger Has Warnings
     *
     * @return bool
     */
    public function hasWarnings(): bool
    {
        return $this->maxLevel >= Logger::WARNING;
    }

    /**
     * Check if Loger Has Records for this Level
     *
     * @param int $level
     *
     * @return bool
     */
    public function hasRecords(int $level): bool
    {
        return isset($this->recordsByLevel[$level]);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->recordsByLevel[$record['level']][] = $record;
        $this->records[] = $record;
        $this->maxLevel = ($record['level'] > $this->maxLevel)
            ? $record['level']
            : $this->maxLevel
        ;
    }
}

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

namespace BadPixxel\Paddock\Backup\Events;

use Symfony\Contracts\EventDispatcher\Event;

class GetOperationsEvent extends Event
{
    /**
     * @var array<string, array>
     */
    private $operations = array();

    /**
     * Add Operation.
     *
     * @param string $code
     * @param array  $definition
     *
     * @return self
     */
    public function add(string $code, array $definition): self
    {
        $this->operations[$code] = $definition;

        return $this;
    }

    /**
     * Get All Operations.
     *
     * @return array<string, array>
     */
    public function all(): array
    {
        return $this->operations;
    }
}

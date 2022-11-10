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
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonFormatter
 */
class JsonFormatter extends AbstractFormatter
{
    /**
     * {@inheritDoc}
     */
    public function getStatusCode(): int
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus(): string
    {
        return (string) json_encode(array(
            "logs" => $this->records,
            "counters" => $this->counters,
            "options" => $this->options,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getResponse(): Response
    {
        return new Response(
            $this->getStatus(),
            Response::HTTP_OK
        );
    }

    /**
     * Analyze Records
     */
    protected function parse(): void
    {
    }
}

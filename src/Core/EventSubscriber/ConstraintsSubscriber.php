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

namespace BadPixxel\Paddock\Core\EventSubscriber;

use BadPixxel\Paddock\Core\Events\GetConstraintsEvent;
use BadPixxel\Paddock\Core\Rules;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConstraintsSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            GetConstraintsEvent::class => "registerConstraints",
        );
    }

    /**
     * @param GetConstraintsEvent $event
     */
    public function registerConstraints(GetConstraintsEvent $event): void
    {
        $event->add(Rules\Value::class);
    }
}

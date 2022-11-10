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

namespace BadPixxel\Paddock\System\Shell\EventSubscriber;

use BadPixxel\Paddock\Core\Events\GetConstraintsEvent;
use BadPixxel\Paddock\System\Shell\Rules;
use Exception;
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
     * Add Bundle Rules to Paddock
     *
     * @param GetConstraintsEvent $event
     *
     * @throws Exception
     */
    public function registerConstraints(GetConstraintsEvent $event): void
    {
        $event->add(Rules\Command::class);
    }
}

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

use BadPixxel\Paddock\Core\Events\GetTracksEvent;
use BadPixxel\Paddock\System\Shell\Tracks;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TracksSubscriber implements EventSubscriberInterface
{
    const TEST_ENV = array("dev", "test");

    /**
     * @var string
     */
    private $env;

    /**
     * @param string $env
     */
    public function __construct(string $env)
    {
        $this->env = $env;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            GetTracksEvent::class => "registerTracks",
        );
    }

    /**
     * Add Bundle Tracks to Paddock
     *
     * @param GetTracksEvent $event
     *
     * @throws Exception
     */
    public function registerTracks(GetTracksEvent $event): void
    {
        $event->add(Tracks\SystemUpdatesTrack::class);

        if (in_array($this->env, self::TEST_ENV, true)) {
            $event->add(Tracks\Test\ApacheServiceTrack::class);
        }
    }
}

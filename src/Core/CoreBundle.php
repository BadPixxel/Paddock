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

namespace BadPixxel\Paddock\Core;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Paddock Core Bundle for Monitoring Productions Servers.
 */
class CoreBundle extends Bundle
{
    /**
     * Boot Paddock Core Bundle
     */
    public function boot(): void
    {
        //==============================================================================
        // Force Loading of Services for Static Access
        $this->container->get(Services\RulesManager::class);
    }
}

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

namespace BadPixxel\Paddock\Backup;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Paddock Backup Bundle: Manage Data Backup for Productions Servers.
 */
class BackupBundle extends Bundle
{
    /**
     * Boot Paddock Backup Bundle
     */
    public function boot(): void
    {
        //==============================================================================
        // Force Loading of Services for Static Access
        $this->container->get(Services\BackupManager::class);
    }
}

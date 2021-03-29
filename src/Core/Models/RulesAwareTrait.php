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

namespace BadPixxel\Paddock\Core\Models;

use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
use BadPixxel\Paddock\Core\Services\RulesManager;
use Exception;

/**
 * Make a Class Aware of Paddock Rules Manager
 */
trait RulesAwareTrait
{
    //====================================================================//
    // RULES ACCESS
    //====================================================================//

    /**
     * Has a Rule by Code
     *
     * @return bool
     */
    public function hasRule(string $code): bool
    {
        return RulesManager::getInstance()->has($code);
    }

    /**
     * Get a Rule by Code
     *
     * @throws Exception
     *
     * @return AbstractRule
     */
    public function getRuleByCode(string $code): AbstractRule
    {
        return RulesManager::getInstance()->getByCode($code);
    }
}

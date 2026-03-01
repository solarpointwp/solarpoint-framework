<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Bootstrap;

use SolarPoint\Core\PluginInterface;

/**
 * Defines the contract for a bootstrap step.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
interface BootstrapperInterface
{
    /**
     * Runs this bootstrap step for the given plugin.
     *
     * @param PluginInterface $plugin The plugin instance to bootstrap.
     */
    public function bootstrap(PluginInterface $plugin): void;
}

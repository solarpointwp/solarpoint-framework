<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core;

/**
 * Defines the contract for bootstrapping the plugin.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
interface KernelInterface
{
    /**
     * Bootstraps the plugin by running the bootstrap sequence.
     *
     * @param PluginInterface $plugin The plugin instance to bootstrap.
     */
    public function bootstrap(PluginInterface $plugin): void;
}

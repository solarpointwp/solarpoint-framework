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
 * Boots all registered service providers.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class BootServiceProviders implements BootstrapperInterface
{
    /**
     * Calls the boot method on each of the plugin's registered service providers.
     *
     * @param PluginInterface $plugin The plugin instance whose service providers to boot.
     */
    public function bootstrap(PluginInterface $plugin): void
    {
        foreach ($plugin->getServiceProviders() as $provider) {
            $provider->boot();
        }
    }
}

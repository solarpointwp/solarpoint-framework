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

use SolarPoint\Core\Bootstrap\BootstrapperInterface;

/**
 * Bootstraps the plugin by running the configured bootstrappers.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class Kernel implements KernelInterface
{
    /**
     * The bootstrapper classes to run during the bootstrap sequence.
     *
     * @var array<class-string<BootstrapperInterface>>
     */
    protected array $bootstrappers = [
        Bootstrap\RegisterServiceProviders::class,
        Bootstrap\BootServiceProviders::class,
    ];

    public function bootstrap(PluginInterface $plugin): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper())->bootstrap($plugin);
        }
    }
}

<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\ServiceProvider;

/**
 * Defines the contract for registering services into the container.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
interface ServiceProviderInterface
{
    /**
     * Registers services with the container.
     */
    public function register(): void;

    /**
     * Bootstraps any services registered by this provider.
     */
    public function boot(): void;

    /**
     * Returns the list of services provided by this provider.
     *
     * @return array<class-string> The class or interface names this provider binds.
     */
    public function provides(): array;
}

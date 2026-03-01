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

use SolarPoint\Container\ContainerInterface;

/**
 * Base class for registering services into the container.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    /**
     * Constructor.
     */
    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    public function register(): void
    {
    }

    public function boot(): void
    {
    }

    public function provides(): array
    {
        return [];
    }
}

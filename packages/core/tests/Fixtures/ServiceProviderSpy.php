<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests\Fixtures;

use SolarPoint\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Fixture service provider that records register() and boot() calls.
 *
 * @internal
 */
final class ServiceProviderSpy extends AbstractServiceProvider
{
    public static bool $registered = false;

    public static bool $booted = false;

    public function register(): void
    {
        self::$registered = true;
    }

    public function boot(): void
    {
        self::$booted = true;
    }

    public static function reset(): void
    {
        self::$registered = false;
        self::$booted = false;
    }
}

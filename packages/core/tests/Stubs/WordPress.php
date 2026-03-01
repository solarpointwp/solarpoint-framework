<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests\Stubs;

/**
 * Controllable stubs for WordPress functions used in tests.
 *
 * Tests set the static properties to control what WordPress function stubs return.
 * Call reset() in setUp() to ensure a clean state between tests.
 *
 * The global function stubs are defined in tests/bootstrap.php.
 *
 * @internal
 */
final class WordPress
{
    /**
     * Controls the return value of the wp_get_environment_type() stub.
     */
    public static string $environmentType = 'production';

    /**
     * Resets all stub values to their defaults.
     */
    public static function reset(): void
    {
        self::$environmentType = 'production';
    }
}

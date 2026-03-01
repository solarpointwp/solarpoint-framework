<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests\Fixtures\Bootstrap;

use SolarPoint\Core\PluginInterface;

/**
 * Records bootstrapper invocations for test assertions.
 *
 * @internal
 */
final class BootstrapperSpy
{
    /** @var array<string> */
    public static array $entries = [];

    public static ?PluginInterface $lastPlugin = null;

    public static function reset(): void
    {
        self::$entries = [];
        self::$lastPlugin = null;
    }
}

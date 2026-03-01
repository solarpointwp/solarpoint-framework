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

use SolarPoint\Core\Bootstrap\BootstrapperInterface;
use SolarPoint\Core\PluginInterface;

/**
 * Fixture bootstrapper that records 'A' when invoked.
 *
 * @internal
 */
final class BootstrapperA implements BootstrapperInterface
{
    public function bootstrap(PluginInterface $plugin): void
    {
        BootstrapperSpy::$entries[] = 'A';
        BootstrapperSpy::$lastPlugin = $plugin;
    }
}

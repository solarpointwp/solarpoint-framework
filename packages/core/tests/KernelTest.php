<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SolarPoint\Core\Kernel;
use SolarPoint\Core\KernelInterface;
use SolarPoint\Core\PluginInterface;
use SolarPoint\Core\Tests\Fixtures\BootstrapperA;
use SolarPoint\Core\Tests\Fixtures\BootstrapperB;
use SolarPoint\Core\Tests\Fixtures\BootstrapperSpy;

/**
 * @internal
 */
#[CoversClass(Kernel::class)]
final class KernelTest extends TestCase
{
    protected function setUp(): void
    {
        BootstrapperSpy::reset();
    }

    protected function tearDown(): void
    {
        BootstrapperSpy::reset();
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('Kernel implements KernelInterface')]
    public function kernelImplementsKernelInterface(): void
    {
        $this->assertContains(KernelInterface::class, \class_implements(Kernel::class));
    }

    // =========================================================
    // bootstrap()
    // =========================================================

    #[Test]
    #[TestDox('bootstrap() instantiates and runs each bootstrapper in order')]
    public function bootstrapInstantiatesAndRunsEachBootstrapperInOrder(): void
    {
        $kernel = new class extends Kernel {
            public function __construct()
            {
                $this->bootstrappers = [
                    BootstrapperA::class,
                    BootstrapperB::class,
                ];
            }
        };

        $kernel->bootstrap($this->createMock(PluginInterface::class));

        $this->assertSame(['A', 'B'], BootstrapperSpy::$entries);
    }

    #[Test]
    #[TestDox('bootstrap() passes the plugin instance to each bootstrapper')]
    public function bootstrapPassesThePluginInstanceToEachBootstrapper(): void
    {
        $kernel = new class extends Kernel {
            public function __construct()
            {
                $this->bootstrappers = [BootstrapperA::class];
            }
        };

        $plugin = $this->createMock(PluginInterface::class);

        $kernel->bootstrap($plugin);

        $this->assertSame($plugin, BootstrapperSpy::$lastPlugin);
    }

    #[Test]
    #[TestDox('bootstrap() completes without error when bootstrappers array is empty')]
    public function bootstrapCompletesWithoutErrorWhenBootstrappersArrayIsEmpty(): void
    {
        $kernel = new class extends Kernel {
            public function __construct()
            {
                $this->bootstrappers = [];
            }
        };

        $this->expectNotToPerformAssertions();

        $kernel->bootstrap($this->createMock(PluginInterface::class));
    }
}

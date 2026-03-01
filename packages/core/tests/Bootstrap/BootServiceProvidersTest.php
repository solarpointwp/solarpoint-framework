<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests\Bootstrap;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SolarPoint\Container\ServiceProvider\ServiceProviderInterface;
use SolarPoint\Core\Bootstrap\BootServiceProviders;
use SolarPoint\Core\Bootstrap\BootstrapperInterface;
use SolarPoint\Core\PluginInterface;
use SolarPoint\Core\Tests\Fixtures\ServiceProviders\ServiceProviderSpy;

/**
 * @internal
 */
#[CoversClass(BootServiceProviders::class)]
final class BootServiceProvidersTest extends TestCase
{
    private BootServiceProviders $subject;

    protected function setUp(): void
    {
        ServiceProviderSpy::reset();
        $this->subject = new BootServiceProviders();
    }

    protected function tearDown(): void
    {
        ServiceProviderSpy::reset();
        unset($this->subject);
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('BootServiceProviders implements BootstrapperInterface')]
    public function bootServiceProvidersImplementsBootstrapperInterface(): void
    {
        $this->assertContains(BootstrapperInterface::class, \class_implements(BootServiceProviders::class));
    }

    // =========================================================
    // bootstrap()
    // =========================================================

    #[Test]
    #[TestDox('bootstrap() calls boot() on each registered service provider')]
    public function bootstrapCallsBootOnEachRegisteredServiceProvider(): void
    {
        $spy = $this->createMock(ServiceProviderInterface::class);
        $spy->expects($this->once())->method('boot');

        $plugin = $this->createMock(PluginInterface::class);
        $plugin->method('getServiceProviders')->willReturn(['TestProvider' => $spy]);

        $this->subject->bootstrap($plugin);
    }

    #[Test]
    #[TestDox('bootstrap() calls boot() on multiple service providers')]
    public function bootstrapCallsBootOnMultipleServiceProviders(): void
    {
        $spyA = $this->createMock(ServiceProviderInterface::class);
        $spyA->expects($this->once())->method('boot');

        $spyB = $this->createMock(ServiceProviderInterface::class);
        $spyB->expects($this->once())->method('boot');

        $plugin = $this->createMock(PluginInterface::class);
        $plugin->method('getServiceProviders')->willReturn([
            'ProviderA' => $spyA,
            'ProviderB' => $spyB,
        ]);

        $this->subject->bootstrap($plugin);
    }

    #[Test]
    #[TestDox('bootstrap() completes without error when no service providers are registered')]
    public function bootstrapCompletesWithoutErrorWhenNoServiceProvidersAreRegistered(): void
    {
        $plugin = $this->createMock(PluginInterface::class);
        $plugin->method('getServiceProviders')->willReturn([]);

        $this->expectNotToPerformAssertions();

        $this->subject->bootstrap($plugin);
    }
}

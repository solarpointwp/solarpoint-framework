<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\Tests\ServiceProvider;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SolarPoint\Container\ContainerInterface;
use SolarPoint\Container\ServiceProvider\AbstractServiceProvider;
use SolarPoint\Container\ServiceProvider\ServiceProviderInterface;

/**
 * @internal
 */
#[CoversClass(AbstractServiceProvider::class)]
final class AbstractServiceProviderTest extends TestCase
{
    private AbstractServiceProvider $subject;

    protected function setUp(): void
    {
        $container = $this->createMock(ContainerInterface::class);

        $this->subject = new class($container) extends AbstractServiceProvider {};
    }

    protected function tearDown(): void
    {
        unset($this->subject);
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('AbstractServiceProvider implements ServiceProviderInterface')]
    public function abstractServiceProviderImplementsServiceProviderInterface(): void
    {
        $this->assertContains(ServiceProviderInterface::class, \class_implements(AbstractServiceProvider::class));
    }

    // =========================================================
    // register()
    // =========================================================

    #[Test]
    #[TestDox('default implementation does nothing and returns without error')]
    public function registerDefaultImplementationDoesNothing(): void
    {
        $this->expectNotToPerformAssertions();

        $this->subject->register();
    }

    // =========================================================
    // boot()
    // =========================================================

    #[Test]
    #[TestDox('default implementation does nothing and returns without error')]
    public function bootDefaultImplementationDoesNothing(): void
    {
        $this->expectNotToPerformAssertions();

        $this->subject->boot();
    }

    // =========================================================
    // provides()
    // =========================================================

    #[Test]
    #[TestDox('default implementation returns an empty array')]
    public function providesDefaultImplementationReturnsEmptyArray(): void
    {
        $this->assertSame([], $this->subject->provides());
    }
}

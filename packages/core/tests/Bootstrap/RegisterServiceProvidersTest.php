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
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SolarPoint\Core\Bootstrap\BootstrapperInterface;
use SolarPoint\Core\Bootstrap\RegisterServiceProviders;
use SolarPoint\Core\PluginInterface;
use SolarPoint\Core\Tests\Fixtures\ServiceProviders\ServiceProviderSpy;

/**
 * @internal
 */
#[CoversClass(RegisterServiceProviders::class)]
final class RegisterServiceProvidersTest extends TestCase
{
    private RegisterServiceProviders $subject;

    protected function setUp(): void
    {
        $this->subject = new RegisterServiceProviders();
    }

    protected function tearDown(): void
    {
        unset($this->subject);
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('RegisterServiceProviders implements BootstrapperInterface')]
    public function registerServiceProvidersImplementsBootstrapperInterface(): void
    {
        $this->assertContains(BootstrapperInterface::class, \class_implements(RegisterServiceProviders::class));
    }

    // =========================================================
    // bootstrap()
    // =========================================================

    #[Test]
    #[TestDox('bootstrap() registers providers from the bootstrap file')]
    public function bootstrapRegistersProvidersFromTheBootstrapFile(): void
    {
        $plugin = $this->createPluginMock(
            __DIR__.'/../Fixtures/php/providers-valid.php',
        );

        $captured = null;
        $plugin->expects($this->once())
            ->method('registerConfiguredServiceProviders')
            ->willReturnCallback(function (array $providers) use (&$captured): void {
                $captured = $providers;
            })
        ;

        $this->subject->bootstrap($plugin);

        $this->assertSame([ServiceProviderSpy::class], $captured);
    }

    #[Test]
    #[TestDox('bootstrap() skips entries for non-existent classes and non-string values')]
    public function bootstrapSkipsEntriesForNonExistentClassesAndNonStringValues(): void
    {
        $plugin = $this->createPluginMock(
            __DIR__.'/../Fixtures/php/providers-mixed.php',
        );

        $captured = null;
        $plugin->expects($this->once())
            ->method('registerConfiguredServiceProviders')
            ->willReturnCallback(function (array $providers) use (&$captured): void {
                $captured = $providers;
            })
        ;

        $this->subject->bootstrap($plugin);

        $this->assertSame([ServiceProviderSpy::class], $captured);
    }

    #[Test]
    #[TestDox('bootstrap() ignores the file when it returns a non-array')]
    public function bootstrapIgnoresTheFileWhenItReturnsANonArray(): void
    {
        $plugin = $this->createPluginMock(
            __DIR__.'/../Fixtures/php/providers-non-array.php',
        );

        $captured = null;
        $plugin->expects($this->once())
            ->method('registerConfiguredServiceProviders')
            ->willReturnCallback(function (array $providers) use (&$captured): void {
                $captured = $providers;
            })
        ;

        $this->subject->bootstrap($plugin);

        $this->assertSame([], $captured);
    }

    #[Test]
    #[TestDox('bootstrap() completes when the bootstrap file does not exist')]
    public function bootstrapCompletesWhenTheBootstrapFileDoesNotExist(): void
    {
        $plugin = $this->createPluginMock(
            '/nonexistent/path/providers.php',
        );

        $captured = null;
        $plugin->expects($this->once())
            ->method('registerConfiguredServiceProviders')
            ->willReturnCallback(function (array $providers) use (&$captured): void {
                $captured = $providers;
            })
        ;

        $this->subject->bootstrap($plugin);

        $this->assertSame([], $captured);
    }

    /** @param array<string> $excluded */
    private function createPluginMock(string $bootstrapPath, array $excluded = []): MockObject&PluginInterface
    {
        $plugin = $this->createMock(PluginInterface::class);

        $plugin->method('getBootstrapPath')
            ->with('providers.php')
            ->willReturn($bootstrapPath)
        ;

        $plugin->method('getExcludedServiceProviders')
            ->willReturn($excluded)
        ;

        return $plugin;
    }
}

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
use SolarPoint\Container\ContainerInterface;
use SolarPoint\Core\Bootstrap\BootstrapperInterface;
use SolarPoint\Core\Bootstrap\LoadConfiguration;
use SolarPoint\Core\Exceptions\InvalidConfigurationException;
use SolarPoint\Core\PluginInterface;
use SolarPoint\Core\Tests\Fixtures\Configuration\LogConfig;
use SolarPoint\Core\Tests\Fixtures\Configuration\PluginConfig;

/**
 * @internal
 */
#[CoversClass(LoadConfiguration::class)]
final class LoadConfigurationTest extends TestCase
{
    private LoadConfiguration $subject;

    protected function setUp(): void
    {
        $this->subject = new LoadConfiguration();
    }

    protected function tearDown(): void
    {
        unset($this->subject);
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('LoadConfiguration implements BootstrapperInterface')]
    public function loadConfigurationImplementsBootstrapperInterface(): void
    {
        $this->assertContains(BootstrapperInterface::class, \class_implements(LoadConfiguration::class));
    }

    // =========================================================
    // bootstrap()
    // =========================================================

    #[Test]
    #[TestDox('bootstrap() loads and binds configuration objects in the container')]
    public function bootstrapLoadsAndBindsConfigurationObjectsInTheContainer(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $plugin = $this->createPluginMock(
            __DIR__.'/../Fixtures/config/valid',
            $container,
        );

        $bindings = [];
        $container->expects($this->exactly(2))
            ->method('instance')
            ->willReturnCallback(function (string $abstract, object $instance) use (&$bindings): void {
                $bindings[$abstract] = $instance;
            })
        ;

        $this->subject->bootstrap($plugin);

        $this->assertArrayHasKey(LogConfig::class, $bindings);
        $this->assertArrayHasKey(PluginConfig::class, $bindings);
        $this->assertInstanceOf(LogConfig::class, $bindings[LogConfig::class]);
        $this->assertInstanceOf(PluginConfig::class, $bindings[PluginConfig::class]);
    }

    #[Test]
    #[TestDox('bootstrap() skips when the config directory does not exist')]
    public function bootstrapSkipsWhenTheConfigDirectoryDoesNotExist(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $plugin = $this->createPluginMock(
            '/nonexistent/path/config',
            $container,
        );

        $container->expects($this->never())
            ->method('instance')
        ;

        $this->subject->bootstrap($plugin);
    }

    #[Test]
    #[TestDox('bootstrap() throws InvalidConfigurationException when a config file does not return an object')]
    public function bootstrapThrowsInvalidConfigurationExceptionWhenAConfigFileDoesNotReturnAnObject(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $plugin = $this->createPluginMock(
            __DIR__.'/../Fixtures/config/invalid',
            $container,
        );

        $this->expectException(InvalidConfigurationException::class);

        $this->subject->bootstrap($plugin);
    }

    private function createPluginMock(string $configPath, ContainerInterface $container): MockObject&PluginInterface
    {
        $plugin = $this->createMock(PluginInterface::class);

        $plugin->method('getConfigPath')
            ->willReturn($configPath)
        ;

        $plugin->method('getContainer')
            ->willReturn($container)
        ;

        return $plugin;
    }
}

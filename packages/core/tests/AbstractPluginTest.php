<?php

/**
 * This file is part of the SolarPointWP framework.
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
use SolarPoint\Container\ContainerInterface;
use SolarPoint\Core\AbstractPlugin;
use SolarPoint\Core\PluginInterface;

/**
 * @internal
 */
#[CoversClass(AbstractPlugin::class)]
final class AbstractPluginTest extends TestCase
{
    private AbstractPlugin $plugin;

    protected function setUp(): void
    {
        $this->plugin = new class('/var/www/wp-content/plugins/test-plugin/test-plugin.php') extends AbstractPlugin {
            public function getName(): string
            {
                return 'Test Plugin';
            }

            public function getVersion(): string
            {
                return '1.0.0';
            }
        };
    }

    protected function tearDown(): void
    {
        unset($this->plugin);
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('Plugin implements PluginInterface')]
    public function pluginImplementsPluginInterface(): void
    {
        $this->assertInstanceOf(PluginInterface::class, $this->plugin);
    }

    // =========================================================
    // getName()
    // =========================================================

    #[Test]
    #[TestDox('getName() returns the plugin name')]
    public function getNameReturnsThePluginName(): void
    {
        $this->assertSame('Test Plugin', $this->plugin->getName());
    }

    // =========================================================
    // getVersion()
    // =========================================================

    #[Test]
    #[TestDox('getVersion() returns the plugin version')]
    public function getVersionReturnsThePluginVersion(): void
    {
        $this->assertSame('1.0.0', $this->plugin->getVersion());
    }

    // =========================================================
    // onPluginsLoaded()
    // =========================================================

    #[Test]
    #[TestDox('onPluginsLoaded() boots the plugin')]
    public function onPluginsLoadedBootsThePlugin(): void
    {
        $this->assertFalse($this->plugin->isBooted(), 'Plugin should not be booted initially.');

        $this->plugin->onPluginsLoaded();

        $this->assertTrue($this->plugin->isBooted(), 'Plugin should be booted after hook fires.');
    }

    #[Test]
    #[TestDox('onPluginsLoaded() is idempotent (does not boot twice)')]
    public function onPluginsLoadedIsIdempotent(): void
    {
        $this->plugin->onPluginsLoaded();
        $this->assertTrue($this->plugin->isBooted());

        $this->plugin->onPluginsLoaded();

        $this->assertTrue($this->plugin->isBooted());
    }

    // =========================================================
    // getBasePath()
    // =========================================================

    #[Test]
    #[TestDox('getBasePath() returns the plugin\'s base directory')]
    public function getBasePathReturnsThePluginsBaseDirectory(): void
    {
        $this->assertSame('/var/www/wp-content/plugins/test-plugin', $this->plugin->getBasePath());
    }

    #[Test]
    #[TestDox('getBasePath() strips trailing slashes from the base path')]
    public function getBasePathStripsTrailingSlashesFromTheBasePath(): void
    {
        $plugin = new class('/plugin.php') extends AbstractPlugin {
            public function getName(): string
            {
                return 'Test Plugin';
            }

            public function getVersion(): string
            {
                return '1.0.0';
            }
        };

        $this->assertSame('', $plugin->getBasePath());
    }

    #[Test]
    #[TestDox('getBasePath() appends a relative path when provided')]
    public function getBasePathAppendsARelativePathWhenProvided(): void
    {
        $this->assertSame(
            '/var/www/wp-content/plugins/test-plugin/src/views',
            $this->plugin->getBasePath('src/views')
        );
    }

    #[Test]
    #[TestDox('getBasePath() strips leading directory separator from the given path')]
    public function getBasePathStripsLeadingDirectorySeparatorFromTheGivenPath(): void
    {
        $this->assertSame(
            '/var/www/wp-content/plugins/test-plugin/src/views',
            $this->plugin->getBasePath('/src/views')
        );
    }

    #[Test]
    #[TestDox('getBasePath() strips trailing directory separator from the given path')]
    public function getBasePathStripsTrailingDirectorySeparatorFromTheGivenPath(): void
    {
        $this->assertSame(
            '/var/www/wp-content/plugins/test-plugin/src/views',
            $this->plugin->getBasePath('src/views/')
        );
    }

    #[Test]
    #[TestDox('getBasePath() strips both leading and trailing directory separators')]
    public function getBasePathStripsBothLeadingAndTrailingDirectorySeparators(): void
    {
        $this->assertSame(
            '/var/www/wp-content/plugins/test-plugin/src/views',
            $this->plugin->getBasePath('/src/views/')
        );
    }

    #[Test]
    #[TestDox('getBasePath() ignores a path that is only a directory separator')]
    public function getBasePathIgnoresAPathThatIsOnlyADirectorySeparator(): void
    {
        $this->assertSame('/var/www/wp-content/plugins/test-plugin', $this->plugin->getBasePath('/'));
    }

    // =========================================================
    // isBooted()
    // =========================================================

    #[Test]
    #[TestDox('isBooted() returns false before onPluginsLoaded() is called')]
    public function isBootedReturnsFalseBeforeOnPluginsLoadedIsCalled(): void
    {
        $this->assertFalse($this->plugin->isBooted());
    }

    #[Test]
    #[TestDox('isBooted() returns true after onPluginsLoaded() is called')]
    public function isBootedReturnsTrueAfterOnPluginsLoadedIsCalled(): void
    {
        $this->plugin->onPluginsLoaded();

        $this->assertTrue($this->plugin->isBooted());
    }

    // =========================================================
    // getContainer()
    // =========================================================

    #[Test]
    #[TestDox('getContainer() returns a ContainerInterface instance')]
    public function getContainerReturnsAContainerInterfaceInstance(): void
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->plugin->getContainer());
    }

    #[Test]
    #[TestDox('getContainer() returns the same instance on subsequent calls')]
    public function getContainerReturnsTheSameInstanceOnSubsequentCalls(): void
    {
        $this->assertSame($this->plugin->getContainer(), $this->plugin->getContainer());
    }
}

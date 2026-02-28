<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core;

use SolarPoint\Container\Container;
use SolarPoint\Container\ContainerInterface;

/**
 * The abstract base class for building WordPress plugins.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
abstract class AbstractPlugin implements PluginInterface
{
    /**
     * The base path of the plugin.
     */
    private string $basePath;

    /**
     * Indicates whether the plugin has been booted.
     */
    private bool $booted = false;

    /**
     * The service container instance for the plugin.
     */
    private ContainerInterface $container;

    /**
     * The current WordPress environment type.
     */
    private EnvironmentType $environmentType;

    /**
     * Constructor.
     *
     * @param string $file The absolute path to the plugin's main file (i.e. __FILE__).
     */
    public function __construct(string $file)
    {
        $this->setBasePath($file);
        $this->container = new Container();
        $this->detectEnvironment();
    }

    abstract public function getName(): string;

    abstract public function getVersion(): string;

    public function run(): void
    {
        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
    }

    /**
     * Fires when WordPress has finished loading all active plugins.
     *
     * Registered as the callback for the plugins_loaded action hook. Triggers
     * the plugin boot sequence.
     */
    public function onPluginsLoaded(): void
    {
        $this->boot();
    }

    public function getBasePath(string $path = ''): string
    {
        $path = \trim($path, \DIRECTORY_SEPARATOR);

        return $this->basePath.($path !== '' ? \DIRECTORY_SEPARATOR.$path : '');
    }

    public function environment(): EnvironmentType
    {
        return $this->environmentType;
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Boots the plugin.
     */
    private function boot(): void
    {
        if ($this->isBooted()) {
            return;
        }

        $this->booted = true;
    }

    /**
     * Detects and caches the current WordPress environment type.
     */
    private function detectEnvironment(): void
    {
        $this->environmentType = (new Environment())->type();
    }

    /**
     * Sets the base path for the plugin.
     *
     * @param string $file The absolute path to the plugin's main file.
     */
    private function setBasePath(string $file): void
    {
        $this->basePath = \rtrim(\dirname($file), '\/');
    }
}

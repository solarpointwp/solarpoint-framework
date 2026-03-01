<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core;

use SolarPoint\Container\ContainerInterface;
use SolarPoint\Container\ServiceProvider\ServiceProviderInterface;

/**
 * Defines the contract for a WordPress plugin.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
interface PluginInterface
{
    /**
     * Returns the plugin's name.
     *
     * @return string The plugin name.
     */
    public function getName(): string;

    /**
     * Returns the plugin's version.
     *
     * @return string The plugin version.
     */
    public function getVersion(): string;

    /**
     * Starts the plugin lifecycle by registering the plugins_loaded action hook.
     *
     * Call this method from the plugin's main file to initialize the plugin.
     */
    public function run(): void;

    /**
     * Returns the plugin's base path.
     *
     * @param string $path Optional. A relative path to append to the base path. Default: ''.
     *
     * @return string The base path, or the base path with the given relative path appended.
     */
    public function getBasePath(string $path = ''): string;

    /**
     * Returns the path to the bootstrap directory.
     *
     * @param string $path Optional. A relative path to append to the bootstrap path. Default: ''.
     *
     * @return string The bootstrap path, or the bootstrap path with the given relative path appended.
     */
    public function getBootstrapPath(string $path = ''): string;

    /**
     * Returns the path to the configuration directory.
     *
     * @param string $path Optional. A relative path to append to the config path. Default: ''.
     *
     * @return string The config path, or the config path with the given relative path appended.
     */
    public function getConfigPath(string $path = ''): string;

    /**
     * Returns the current environment type.
     *
     * @return EnvironmentType The current environment type.
     */
    public function environment(): EnvironmentType;

    /**
     * Registers the framework's default and plugin-configured service providers.
     *
     * @param array<class-string> $providers The service provider class names to register.
     */
    public function registerConfiguredServiceProviders(array $providers): void;

    /**
     * Registers a service provider with the plugin.
     *
     * @param class-string $provider The service provider class name.
     */
    public function register(string $provider): void;

    /**
     * Excludes default framework service providers from registration.
     *
     * @param array<class-string> $providers The service provider class names to exclude.
     */
    public function excludeServiceProviders(array $providers): void;

    /**
     * Returns the default framework service providers excluded from registration.
     *
     * @return array<class-string> The excluded service provider class names.
     */
    public function getExcludedServiceProviders(): array;

    /**
     * Returns all registered service providers.
     *
     * @return array<class-string, ServiceProviderInterface> The registered service provider instances keyed by class name.
     */
    public function getServiceProviders(): array;

    /**
     * Determines whether the plugin has been booted.
     *
     * @return bool True if the plugin has been booted, false otherwise.
     */
    public function isBooted(): bool;

    /**
     * Returns the plugin's service container.
     *
     * @return ContainerInterface The service container instance.
     */
    public function getContainer(): ContainerInterface;
}

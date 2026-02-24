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

use SolarPoint\Container\ContainerInterface;

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

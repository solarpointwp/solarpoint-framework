<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Bootstrap;

use SolarPoint\Container\ContainerInterface;
use SolarPoint\Core\Exceptions\InvalidConfigurationException;
use SolarPoint\Core\PluginInterface;

/**
 * Loads typed configuration objects from the plugin's config directory.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class LoadConfiguration implements BootstrapperInterface
{
    /**
     * Loads the plugin's configuration files and binds them in the container.
     *
     * @param PluginInterface $plugin The plugin instance whose configuration to load.
     */
    public function bootstrap(PluginInterface $plugin): void
    {
        $container = $plugin->getContainer();
        $files = $this->getConfigurationFiles($plugin);

        foreach ($files as $file) {
            $this->loadConfigurationFile($container, $file);
        }
    }

    /**
     * Loads a single configuration file and binds the returned object in the container.
     *
     * @param ContainerInterface $container The service container instance.
     * @param string             $path      The absolute path to the configuration file.
     *
     * @throws InvalidConfigurationException If the file does not return an object.
     */
    protected function loadConfigurationFile(ContainerInterface $container, string $path): void
    {
        $config = require $path;

        if (!\is_object($config)) {
            throw new InvalidConfigurationException(\sprintf(
                'Configuration file "%s" must return an object, %s returned.',
                $path,
                \get_debug_type($config),
            ));
        }

        $container->instance($config::class, $config);
    }

    /**
     * Returns the configuration files from the plugin's config directory.
     *
     * @param PluginInterface $plugin The plugin instance.
     *
     * @return array<string> The absolute paths to the configuration files.
     */
    protected function getConfigurationFiles(PluginInterface $plugin): array
    {
        $configPath = \realpath($plugin->getConfigPath());

        if ($configPath === false) {
            return [];
        }

        $files = \glob($configPath.\DIRECTORY_SEPARATOR.'*.php');

        return $files !== false ? $files : [];
    }
}

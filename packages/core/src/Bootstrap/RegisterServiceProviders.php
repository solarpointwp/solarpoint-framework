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

use SolarPoint\Core\PluginInterface;
use SolarPoint\Core\Support\DefaultServiceProviders;

/**
 * Registers all configured service providers with the plugin.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class RegisterServiceProviders implements BootstrapperInterface
{
    /**
     * Registers the plugin's configured service providers.
     *
     * @param PluginInterface $plugin The plugin instance whose service providers to register.
     */
    public function bootstrap(PluginInterface $plugin): void
    {
        $providers = $this->mergeServiceProviders($plugin);

        $plugin->registerConfiguredServiceProviders($providers);
    }

    /**
     * Merges the framework's default service providers with the plugin's configured providers.
     *
     * @param PluginInterface $plugin The plugin instance.
     *
     * @return array<class-string> The merged list of service provider class names.
     */
    protected function mergeServiceProviders(PluginInterface $plugin): array
    {
        $exclude = $plugin->getExcludedServiceProviders();

        $defaults = (new DefaultServiceProviders())->toArray();

        $providers = \array_values(\array_diff($defaults, $exclude));

        $path = $this->getBootstrapProvidersPath($plugin);

        if (\file_exists($path)) {
            $configured = require $path;

            if (!\is_array($configured)) {
                return $providers;
            }

            foreach ($configured as $provider) {
                if (\is_string($provider) && \class_exists($provider)) {
                    $providers[] = $provider;
                }
            }
        }

        return $providers;
    }

    /**
     * Returns the path to the bootstrap service providers file.
     *
     * @param PluginInterface $plugin The plugin instance.
     *
     * @return string The absolute path to the providers file.
     */
    protected function getBootstrapProvidersPath(PluginInterface $plugin): string
    {
        return $plugin->getBootstrapPath('providers.php');
    }
}

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

use SolarPoint\Container\Container;
use SolarPoint\Container\ContainerInterface;
use SolarPoint\Container\ServiceProvider\ServiceProviderInterface;

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
    protected string $basePath;

    /**
     * Indicates whether the plugin has been booted.
     */
    protected bool $booted = false;

    /**
     * The custom path to the bootstrap directory.
     */
    protected string $bootstrapPath = '';

    /**
     * The default framework service providers to exclude from registration.
     *
     * @var array<class-string>
     */
    protected array $excludedServiceProviders = [];

    /**
     * The registered service provider instances keyed by class name.
     *
     * @var array<class-string, ServiceProviderInterface>
     */
    protected array $serviceProviders = [];

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
        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
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
        return $this->joinPaths($this->basePath, $path);
    }

    public function getBootstrapPath(string $path = ''): string
    {
        return $this->joinPaths($this->bootstrapPath ?: $this->getBasePath('bootstrap'), $path);
    }

    public function environment(): EnvironmentType
    {
        return $this->environmentType;
    }

    public function registerConfiguredServiceProviders(array $providers): void
    {
        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }

    public function register(string $provider): void
    {
        if ($this->getServiceProvider($provider)) {
            return;
        }

        $instance = new $provider($this->container);

        if (!$instance instanceof ServiceProviderInterface) {
            return;
        }

        $instance->register();

        $this->markAsRegistered($provider, $instance);

        if ($this->isBooted()) {
            $instance->boot();
        }
    }

    public function excludeServiceProviders(array $providers): void
    {
        $this->excludedServiceProviders = \array_merge($this->excludedServiceProviders, $providers);
    }

    public function getExcludedServiceProviders(): array
    {
        return $this->excludedServiceProviders;
    }

    /**
     * Returns a registered service provider instance by class name.
     *
     * @param string $provider The fully qualified service provider class name.
     *
     * @return ServiceProviderInterface|null The service provider instance, or null if not registered.
     */
    public function getServiceProvider(string $provider): ?ServiceProviderInterface
    {
        return $this->serviceProviders[$provider] ?? null;
    }

    public function getServiceProviders(): array
    {
        return $this->serviceProviders;
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
     * Registers the framework's base bindings with the container.
     */
    protected function registerBaseBindings(): void
    {
        $this->container->instance(PluginInterface::class, $this);
        $this->container->singleton(KernelInterface::class, Kernel::class);
    }

    /**
     * Registers the framework's base service providers.
     */
    protected function registerBaseServiceProviders(): void
    {
    }

    /**
     * Boots the plugin.
     */
    protected function boot(): void
    {
        if ($this->isBooted()) {
            return;
        }

        $this->container->make(KernelInterface::class)->bootstrap($this);

        $this->booted = true;
    }

    /**
     * Marks a service provider as registered.
     *
     * @param class-string             $provider The fully qualified service provider class name.
     * @param ServiceProviderInterface $instance The service provider instance.
     */
    protected function markAsRegistered(string $provider, ServiceProviderInterface $instance): void
    {
        $this->serviceProviders[$provider] = $instance;
    }

    /**
     * Detects and caches the current WordPress environment type.
     */
    private function detectEnvironment(): void
    {
        $this->environmentType = (new Environment())->type();
    }

    /**
     * Joins a base path with a relative path segment.
     *
     * @param string $base The absolute base path.
     * @param string $path The relative path to append.
     *
     * @return string The joined path.
     */
    private function joinPaths(string $base, string $path): string
    {
        $path = \trim($path, \DIRECTORY_SEPARATOR);

        return $base.($path !== '' ? \DIRECTORY_SEPARATOR.$path : '');
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

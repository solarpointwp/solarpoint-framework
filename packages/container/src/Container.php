<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container;

use Closure;
use SolarPoint\Container\Exceptions\BindingResolutionException;
use SolarPoint\Container\Exceptions\ServiceCircularReferenceException;

/**
 * The service container for registering bindings, resolving services, and caching shared instances.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
final class Container implements ContainerInterface
{
    /**
     * Registered bindings keyed by abstract identifier.
     *
     * @var array<class-string, array{concrete: Closure(Container, array<string, mixed>): object, shared: bool}>
     */
    private array $bindings = [];

    /**
     * Resolved shared instances keyed by abstract identifier.
     *
     * @var array<class-string, object>
     */
    private array $instances = [];

    /**
     * Tracks which abstract identifiers have been resolved at least once.
     *
     * @var array<class-string, bool>
     */
    private array $resolved = [];

    /**
     * Tracks the stack of classes currently being built to detect circular dependencies.
     *
     * @var list<class-string>
     */
    private array $buildStack = [];

    public function bind(string $abstract, Closure|string|null $concrete = null, bool $isShared = false): void
    {
        $this->dropStaleInstances($abstract);

        $concrete ??= $abstract;

        if (!$concrete instanceof Closure) {
            $concrete = $this->getClosure($abstract, $concrete);
        }

        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $isShared,
        ];
    }

    public function bindIf(string $abstract, Closure|string|null $concrete = null, bool $isShared = false): void
    {
        if (!$this->bound($abstract)) {
            $this->bind($abstract, $concrete, $isShared);
        }
    }

    public function singleton(string $abstract, Closure|string|null $concrete = null): void
    {
        $this->bind($abstract, $concrete, true);
    }

    public function singletonIf(string $abstract, Closure|string|null $concrete = null): void
    {
        if (!$this->bound($abstract)) {
            $this->singleton($abstract, $concrete);
        }
    }

    public function instance(string $abstract, object $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function make(string $abstract, array $parameters = []): object
    {
        return $this->resolve($abstract, $parameters);
    }

    public function bound(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }

    /**
     * Determines whether the given abstract type has been resolved at least once.
     *
     * Intended for introspection only. This method does not affect resolution behaviour.
     *
     * @param class-string $abstract The class or interface name.
     *
     * @return bool True if the abstract type has been resolved, false otherwise.
     */
    public function isResolved(string $abstract): bool
    {
        return isset($this->resolved[$abstract]) || isset($this->instances[$abstract]);
    }

    public function isShared(string $abstract): bool
    {
        return isset($this->instances[$abstract])
            || (isset($this->bindings[$abstract]) && $this->bindings[$abstract]['shared'] === true);
    }

    public function flush(): void
    {
        $this->bindings = [];
        $this->instances = [];
        $this->resolved = [];
    }

    /**
     * Resolves an abstract type, returning a cached instance if available or building a new one.
     *
     * @template T of object
     *
     * @param class-string<T>      $abstract   The class or interface name.
     * @param array<string, mixed> $parameters Optional. Constructor arguments that cannot be resolved by the container, keyed by parameter name. Default: [].
     *
     * @return T The resolved service instance.
     *
     * @throws BindingResolutionException        If the target class is not bound in the container.
     * @throws ServiceCircularReferenceException If a circular dependency is detected.
     */
    private function resolve(string $abstract, array $parameters = []): object
    {
        if (isset($this->instances[$abstract])) {
            /** @var T */
            return $this->instances[$abstract];
        }

        if (\in_array($abstract, $this->buildStack, true)) {
            throw new ServiceCircularReferenceException(
                \sprintf(
                    'Circular dependency detected for [%s]. Resolution chain: %s.',
                    $abstract,
                    \implode(' -> ', [...$this->buildStack, $abstract]),
                )
            );
        }

        if (!isset($this->bindings[$abstract])) {
            throw new BindingResolutionException(
                \sprintf('Target [%s] is not bound in the container. Did you forget to call bind() or singleton()?', $abstract)
            );
        }

        $this->buildStack[] = $abstract;

        try {
            $object = $this->build($abstract, $parameters);

            if ($this->isShared($abstract)) {
                $this->instances[$abstract] = $object;
            }

            $this->resolved[$abstract] = true;

            /** @var T */
            return $object;
        } finally {
            \array_pop($this->buildStack);
        }
    }

    /**
     * Builds and returns a new instance of the given abstract type.
     *
     * @param class-string         $abstract   The class or interface name.
     * @param array<string, mixed> $parameters Parameters to pass during instantiation.
     *
     * @return object The newly built instance.
     *
     * @throws BindingResolutionException        If the concrete class does not exist and cannot be resolved.
     * @throws ServiceCircularReferenceException If a circular dependency is detected during nested resolution.
     */
    private function build(string $abstract, array $parameters): object
    {
        $concrete = $this->bindings[$abstract]['concrete'];

        // ServiceCircularReferenceException may bubble up if the closure delegates back to make().
        return $concrete($this, $parameters);
    }

    /**
     * Gets the Closure to resolve the given concrete type.
     *
     * @param class-string $abstract The class or interface name.
     * @param string       $concrete The concrete class name to wrap.
     *
     * @return Closure A Closure that resolves the concrete class when invoked.
     */
    private function getClosure(string $abstract, string $concrete): Closure
    {
        return function (Container $container, array $parameters) use ($abstract, $concrete): object {
            /**
             * @var class-string         $concrete
             * @var array<string, mixed> $parameters
             */
            if ($abstract === $concrete) {
                return new $concrete(...$parameters);
            }

            if ($container->bound($concrete)) {
                return $container->make($concrete, $parameters);
            }

            if (\class_exists($concrete)) {
                return new $concrete(...$parameters);
            }

            throw new BindingResolutionException(
                \sprintf('Target class [%s] does not exist.', $concrete)
            );
        };
    }

    /**
     * Drops the stale instance for the given abstract identifier.
     *
     * @param class-string $abstract The class or interface name.
     */
    private function dropStaleInstances(string $abstract): void
    {
        unset($this->instances[$abstract]);
    }
}

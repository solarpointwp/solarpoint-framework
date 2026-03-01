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
 * Defines the contract for registering, resolving, and managing service bindings.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
interface ContainerInterface
{
    /**
     * Registers a binding with the container.
     *
     * @param class-string        $abstract The class or interface name.
     * @param Closure|string|null $concrete Optional. The concrete implementation, class name, or factory closure. Default: null.
     * @param bool                $isShared Optional. Whether to resolve the binding as a shared instance. Default: false.
     */
    public function bind(string $abstract, Closure|string|null $concrete = null, bool $isShared = false): void;

    /**
     * Registers a binding with the container if one does not already exist.
     *
     * @param class-string        $abstract The class or interface name.
     * @param Closure|string|null $concrete Optional. The concrete implementation, class name, or factory closure. Default: null.
     * @param bool                $isShared Optional. Whether to resolve the binding as a shared instance. Default: false.
     */
    public function bindIf(string $abstract, Closure|string|null $concrete = null, bool $isShared = false): void;

    /**
     * Registers a shared binding with the container that is resolved only once.
     *
     * @param class-string        $abstract The class or interface name.
     * @param Closure|string|null $concrete Optional. The concrete implementation, class name, or factory closure. Default: null.
     */
    public function singleton(string $abstract, Closure|string|null $concrete = null): void;

    /**
     * Registers a shared binding with the container if one does not already exist.
     *
     * @param class-string        $abstract The class or interface name.
     * @param Closure|string|null $concrete Optional. The concrete implementation, class name, or factory closure. Default: null.
     */
    public function singletonIf(string $abstract, Closure|string|null $concrete = null): void;

    /**
     * Registers an existing object instance as shared in the container.
     *
     * @param class-string $abstract The class or interface name.
     * @param object       $instance The object instance to register.
     */
    public function instance(string $abstract, object $instance): void;

    /**
     * Resolves a service from the container.
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
    public function make(string $abstract, array $parameters = []): object;

    /**
     * Determines whether a binding or instance exists for the given identifier.
     *
     * @param class-string $abstract The class or interface name.
     *
     * @return bool True if a binding or instance exists, false otherwise.
     */
    public function bound(string $abstract): bool;

    /**
     * Determines whether the given abstract type is shared in the container.
     *
     * @param class-string $abstract The class or interface name.
     *
     * @return bool True if the binding is shared or a shared instance exists, false otherwise.
     */
    public function isShared(string $abstract): bool;

    /**
     * Flushes the container of all bindings, instances, and resolved state.
     */
    public function flush(): void;
}

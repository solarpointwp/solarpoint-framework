<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Hooks;

/**
 * Defines the contract for registering and managing WordPress actions and filters.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
interface HookInterface
{
    /**
     * Registers an action hook callback.
     *
     * @param non-empty-string $hookName     The action hook name.
     * @param callable         $callback     The callback to execute when the action fires.
     * @param int              $priority     Optional. The priority at which the callback is executed. Default: 10.
     * @param int              $acceptedArgs Optional. The number of arguments the callback accepts. Default: 1.
     */
    public function addAction(string $hookName, callable $callback, int $priority = 10, int $acceptedArgs = 1): void;

    /**
     * Returns the number of times an action hook has been fired.
     *
     * @param non-empty-string $hookName The action hook name.
     *
     * @return int The number of times the action has been fired.
     */
    public function didAction(string $hookName): int;

    /**
     * Executes all callbacks registered to an action hook.
     *
     * @param non-empty-string $hookName The action hook name.
     * @param mixed            ...$args  Optional. Arguments passed to the callbacks.
     */
    public function doAction(string $hookName, mixed ...$args): void;

    /**
     * Determines whether an action hook is currently being executed.
     *
     * @param non-empty-string|null $hookName Optional. The action hook name. Checks for any action if null. Default: null.
     */
    public function doingAction(?string $hookName = null): bool;

    /**
     * Checks whether an action hook has any registered callbacks.
     *
     * @param non-empty-string                   $hookName The action hook name.
     * @param array<mixed>|callable|false|string $callback Optional. The callback to check for. Default: false.
     *
     * @return bool|int False if not found, true if found without a callback check, or the priority as an integer.
     */
    public function hasAction(string $hookName, array|callable|false|string $callback = false): bool|int;

    /**
     * Removes an action hook callback.
     *
     * @param non-empty-string             $hookName The action hook name.
     * @param array<mixed>|callable|string $callback The callback to remove.
     * @param int                          $priority Optional. The priority of the callback to remove. Default: 10.
     *
     * @return bool True if the callback was successfully removed, false otherwise.
     */
    public function removeAction(string $hookName, array|callable|string $callback, int $priority = 10): bool;

    /**
     * Registers a filter hook callback.
     *
     * @param non-empty-string $hookName     The filter hook name.
     * @param callable         $callback     The callback to execute when the filter is applied.
     * @param int              $priority     Optional. The priority at which the callback is executed. Default: 10.
     * @param int              $acceptedArgs Optional. The number of arguments the callback accepts. Default: 1.
     */
    public function addFilter(string $hookName, callable $callback, int $priority = 10, int $acceptedArgs = 1): void;

    /**
     * Applies all callbacks registered to a filter hook to the given value.
     *
     * @param non-empty-string $hookName The filter hook name.
     * @param mixed            $value    The value to filter.
     * @param mixed            ...$args  Optional. Additional arguments passed to the callbacks.
     *
     * @return mixed The filtered value.
     */
    public function applyFilters(string $hookName, mixed $value, mixed ...$args): mixed;

    /**
     * Returns the number of times a filter hook has been applied.
     *
     * @param non-empty-string $hookName The filter hook name.
     *
     * @return int The number of times the filter has been applied.
     */
    public function didFilter(string $hookName): int;

    /**
     * Determines whether a filter hook is currently being applied.
     *
     * @param non-empty-string|null $hookName Optional. The filter hook name. Checks for any filter if null. Default: null.
     */
    public function doingFilter(?string $hookName = null): bool;

    /**
     * Checks whether a filter hook has any registered callbacks.
     *
     * @param non-empty-string                   $hookName The filter hook name.
     * @param array<mixed>|callable|false|string $callback Optional. The callback to check for. Default: false.
     *
     * @return bool|int False if not found, true if found without a callback check, or the priority as an integer.
     */
    public function hasFilter(string $hookName, array|callable|false|string $callback = false): bool|int;

    /**
     * Removes a filter hook callback.
     *
     * @param non-empty-string             $hookName The filter hook name.
     * @param array<mixed>|callable|string $callback The callback to remove.
     * @param int                          $priority Optional. The priority of the callback to remove. Default: 10.
     *
     * @return bool True if the callback was successfully removed, false otherwise.
     */
    public function removeFilter(string $hookName, array|callable|string $callback, int $priority = 10): bool;
}

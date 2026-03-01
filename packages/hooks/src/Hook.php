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
 * Delegates WordPress action and filter operations to the underlying hook functions.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
final class Hook implements HookInterface
{
    public function addAction(string $hookName, callable $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
        add_action($hookName, $callback, $priority, $acceptedArgs);
    }

    public function didAction(string $hookName): int
    {
        return did_action($hookName);
    }

    public function doAction(string $hookName, mixed ...$args): void
    {
        do_action($hookName, ...$args);
    }

    public function doingAction(?string $hookName = null): bool
    {
        return doing_action($hookName);
    }

    public function hasAction(string $hookName, array|callable|false|string $callback = false): bool|int
    {
        return has_action($hookName, $callback);
    }

    public function removeAction(string $hookName, array|callable|string $callback, int $priority = 10): bool
    {
        return remove_action($hookName, $callback, $priority);
    }

    public function addFilter(string $hookName, callable $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
        add_filter($hookName, $callback, $priority, $acceptedArgs);
    }

    public function applyFilters(string $hookName, mixed $value, mixed ...$args): mixed
    {
        return apply_filters($hookName, $value, ...$args);
    }

    public function didFilter(string $hookName): int
    {
        return did_filter($hookName);
    }

    public function doingFilter(?string $hookName = null): bool
    {
        return doing_filter($hookName);
    }

    public function hasFilter(string $hookName, array|callable|false|string $callback = false): bool|int
    {
        return has_filter($hookName, $callback);
    }

    public function removeFilter(string $hookName, array|callable|string $callback, int $priority = 10): bool
    {
        return remove_filter($hookName, $callback, $priority);
    }
}

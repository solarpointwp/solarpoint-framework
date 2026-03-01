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

/**
 * Represents the available WordPress environment types.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
enum EnvironmentType: string
{
    case Production = 'production';
    case Staging = 'staging';
    case Development = 'development';
    case Local = 'local';

    /**
     * Determines whether the current environment type matches one of the given types.
     *
     * @param self ...$types One or more environment types to check against.
     *
     * @return bool True if the current type matches any of the given types, false otherwise.
     */
    public function is(self ...$types): bool
    {
        return \in_array($this, $types, true);
    }

    /**
     * Returns the display label for the environment type.
     *
     * @return string The display label for this environment type.
     */
    public function label(): string
    {
        return match ($this) {
            self::Production => 'Production',
            self::Staging => 'Staging',
            self::Development => 'Development',
            self::Local => 'Local',
        };
    }
}

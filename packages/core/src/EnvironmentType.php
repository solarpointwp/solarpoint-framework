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

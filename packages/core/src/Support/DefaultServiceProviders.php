<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Support;

/**
 * Provides the list of framework service providers registered by default.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
final class DefaultServiceProviders
{
    /**
     * The default service provider class names.
     *
     * @var array<class-string>
     */
    private array $providers = [];

    /**
     * Returns the provider class names as an array.
     *
     * @return array<class-string>
     */
    public function toArray(): array
    {
        return $this->providers;
    }
}

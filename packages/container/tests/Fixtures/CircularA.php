<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\Tests\Fixtures;

/**
 * Depends on CircularB, forming part of a three-node circular dependency chain used as a test fixture.
 *
 * @internal
 */
final class CircularA
{
    public function __construct(public readonly CircularB $dependency)
    {
    }
}

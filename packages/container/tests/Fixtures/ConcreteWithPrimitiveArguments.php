<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\Tests\Fixtures;

/**
 * A concrete class requiring primitive constructor arguments, used as a test fixture.
 *
 * @internal
 */
final class ConcreteWithPrimitiveArguments
{
    public function __construct(
        public readonly string $name,
        public readonly int $value,
    ) {
    }
}

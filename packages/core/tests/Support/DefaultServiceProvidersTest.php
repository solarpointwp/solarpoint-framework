<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests\Support;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SolarPoint\Core\Support\DefaultServiceProviders;

/**
 * @internal
 */
#[CoversClass(DefaultServiceProviders::class)]
final class DefaultServiceProvidersTest extends TestCase
{
    // =========================================================
    // toArray()
    // =========================================================

    #[Test]
    #[TestDox('toArray() returns an empty array')]
    public function toArrayReturnsAnEmptyArray(): void
    {
        $subject = new DefaultServiceProviders();

        $this->assertSame([], $subject->toArray());
    }
}

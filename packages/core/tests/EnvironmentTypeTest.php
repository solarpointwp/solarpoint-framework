<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SolarPoint\Core\EnvironmentType;

/**
 * @internal
 */
#[CoversClass(EnvironmentType::class)]
final class EnvironmentTypeTest extends TestCase
{
    #[Test]
    #[TestDox('Production case has string value production')]
    public function productionCaseHasStringValueProduction(): void
    {
        $this->assertSame('production', EnvironmentType::Production->value);
    }

    #[Test]
    #[TestDox('Staging case has string value staging')]
    public function stagingCaseHasStringValueStaging(): void
    {
        $this->assertSame('staging', EnvironmentType::Staging->value);
    }

    #[Test]
    #[TestDox('Development case has string value development')]
    public function developmentCaseHasStringValueDevelopment(): void
    {
        $this->assertSame('development', EnvironmentType::Development->value);
    }

    #[Test]
    #[TestDox('Local case has string value local')]
    public function localCaseHasStringValueLocal(): void
    {
        $this->assertSame('local', EnvironmentType::Local->value);
    }

    #[Test]
    #[TestDox('from() resolves correct case from string value')]
    public function fromResolvesCorrectCaseFromStringValue(): void
    {
        $this->assertSame(EnvironmentType::Development, EnvironmentType::from('development'));
        $this->assertSame(EnvironmentType::Local, EnvironmentType::from('local'));
    }

    // =========================================================
    // is()
    // =========================================================

    #[Test]
    #[TestDox('is() returns true when type matches the given type')]
    public function isReturnsTrueWhenTypeMatchesTheGivenType(): void
    {
        $this->assertTrue(EnvironmentType::Production->is(EnvironmentType::Production));
    }

    #[Test]
    #[TestDox('is() returns true when type matches one of multiple given types')]
    public function isReturnsTrueWhenTypeMatchesOneOfMultipleGivenTypes(): void
    {
        $this->assertTrue(EnvironmentType::Development->is(EnvironmentType::Staging, EnvironmentType::Development));
    }

    #[Test]
    #[TestDox('is() returns false when type does not match any given type')]
    public function isReturnsFalseWhenTypeDoesNotMatchAnyGivenType(): void
    {
        $this->assertFalse(EnvironmentType::Production->is(EnvironmentType::Development, EnvironmentType::Local));
    }

    // =========================================================
    // label()
    // =========================================================

    #[Test]
    #[TestDox('label() returns the display label for the environment type')]
    public function labelReturnsTheDisplayLabelForTheEnvironmentType(): void
    {
        $this->assertSame('Production', EnvironmentType::Production->label());
        $this->assertSame('Staging', EnvironmentType::Staging->label());
        $this->assertSame('Development', EnvironmentType::Development->label());
        $this->assertSame('Local', EnvironmentType::Local->label());
    }
}

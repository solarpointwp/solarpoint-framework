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
use SolarPoint\Core\Environment;
use SolarPoint\Core\EnvironmentType;
use SolarPoint\Core\Tests\Stubs\WordPress;

/**
 * @internal
 */
#[CoversClass(Environment::class)]
final class EnvironmentTest extends TestCase
{
    private Environment $subject;

    protected function setUp(): void
    {
        WordPress::reset();
        $this->subject = new Environment();
    }

    protected function tearDown(): void
    {
        WordPress::reset();
        unset($this->subject);
    }

    // =========================================================
    // type()
    // =========================================================

    #[Test]
    #[TestDox('type() returns the EnvironmentType matching the wp_get_environment_type() return value')]
    public function typeReturnsMatchingEnvironmentType(): void
    {
        WordPress::$environmentType = 'staging';

        $this->assertSame(EnvironmentType::Staging, $this->subject->type());
    }

    #[Test]
    #[TestDox('type() caches the resolved type on subsequent calls')]
    public function typeCachesTheResolvedType(): void
    {
        WordPress::$environmentType = 'development';
        $this->subject->type();

        WordPress::$environmentType = 'local';

        $this->assertSame(EnvironmentType::Development, $this->subject->type());
    }

    // =========================================================
    // Environment Types
    // =========================================================

    #[Test]
    #[TestDox('isProduction() returns true when environment type is production')]
    public function isProductionReturnsTrueWhenEnvironmentTypeIsProduction(): void
    {
        WordPress::$environmentType = 'production';

        $this->assertTrue($this->subject->isProduction());
    }

    #[Test]
    #[TestDox('isProduction() returns false when environment type is not production')]
    public function isProductionReturnsFalseWhenEnvironmentTypeIsNotProduction(): void
    {
        WordPress::$environmentType = 'staging';

        $this->assertFalse($this->subject->isProduction());
    }

    #[Test]
    #[TestDox('isStaging() returns true when environment type is staging')]
    public function isStagingReturnsTrueWhenEnvironmentTypeIsStaging(): void
    {
        WordPress::$environmentType = 'staging';

        $this->assertTrue($this->subject->isStaging());
    }

    #[Test]
    #[TestDox('isStaging() returns false when environment type is not staging')]
    public function isStagingReturnsFalseWhenEnvironmentTypeIsNotStaging(): void
    {
        WordPress::$environmentType = 'production';

        $this->assertFalse($this->subject->isStaging());
    }

    #[Test]
    #[TestDox('isDevelopment() returns true when environment type is development')]
    public function isDevelopmentReturnsTrueWhenEnvironmentTypeIsDevelopment(): void
    {
        WordPress::$environmentType = 'development';

        $this->assertTrue($this->subject->isDevelopment());
    }

    #[Test]
    #[TestDox('isDevelopment() returns false when environment type is not development')]
    public function isDevelopmentReturnsFalseWhenEnvironmentTypeIsNotDevelopment(): void
    {
        WordPress::$environmentType = 'production';

        $this->assertFalse($this->subject->isDevelopment());
    }

    #[Test]
    #[TestDox('isLocal() returns true when environment type is local')]
    public function isLocalReturnsTrueWhenEnvironmentTypeIsLocal(): void
    {
        WordPress::$environmentType = 'local';

        $this->assertTrue($this->subject->isLocal());
    }

    #[Test]
    #[TestDox('isLocal() returns false when environment type is not local')]
    public function isLocalReturnsFalseWhenEnvironmentTypeIsNotLocal(): void
    {
        WordPress::$environmentType = 'production';

        $this->assertFalse($this->subject->isLocal());
    }

    // =========================================================
    // Debug Flags
    // =========================================================
    // Bootstrap defines: WP_DEBUG=true, WP_DEBUG_LOG=true,
    // WP_DEBUG_DISPLAY=false, SCRIPT_DEBUG=false.

    #[Test]
    #[TestDox('isDebug() returns true when WP_DEBUG is true')]
    public function isDebugReturnsTrueWhenWpDebugIsTrue(): void
    {
        $this->assertTrue($this->subject->isDebug());
    }

    #[Test]
    #[TestDox('isDebugLog() returns true when WP_DEBUG_LOG is true')]
    public function isDebugLogReturnsTrueWhenWpDebugLogIsTrue(): void
    {
        $this->assertTrue($this->subject->isDebugLog());
    }

    #[Test]
    #[TestDox('isDebugDisplay() returns false when WP_DEBUG_DISPLAY is false')]
    public function isDebugDisplayReturnsFalseWhenWpDebugDisplayIsFalse(): void
    {
        $this->assertFalse($this->subject->isDebugDisplay());
    }

    #[Test]
    #[TestDox('isScriptDebug() returns false when SCRIPT_DEBUG is false')]
    public function isScriptDebugReturnsFalseWhenScriptDebugIsFalse(): void
    {
        $this->assertFalse($this->subject->isScriptDebug());
    }

    // =========================================================
    // Request Context
    // =========================================================

    #[Test]
    #[TestDox('isAdmin() returns false when WP_ADMIN is not defined')]
    public function isAdminReturnsFalseWhenWpAdminIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isAdmin());
    }

    #[Test]
    #[TestDox('isAjax() returns false when DOING_AJAX is not defined')]
    public function isAjaxReturnsFalseWhenDoingAjaxIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isAjax());
    }

    #[Test]
    #[TestDox('isCron() returns false when DOING_CRON is not defined')]
    public function isCronReturnsFalseWhenDoingCronIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isCron());
    }

    #[Test]
    #[TestDox('isRest() returns false when REST_REQUEST is not defined')]
    public function isRestReturnsFalseWhenRestRequestIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isRest());
    }

    #[Test]
    #[TestDox('isCli() returns false when WP_CLI is not defined')]
    public function isCliReturnsFalseWhenWpCliIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isCli());
    }

    #[Test]
    #[TestDox('isXmlRpc() returns false when XMLRPC_REQUEST is not defined')]
    public function isXmlRpcReturnsFalseWhenXmlRpcRequestIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isXmlRpc());
    }

    // =========================================================
    // WordPress State
    // =========================================================

    #[Test]
    #[TestDox('isImporting() returns false when WP_IMPORTING is not defined')]
    public function isImportingReturnsFalseWhenWpImportingIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isImporting());
    }

    #[Test]
    #[TestDox('isInstalling() returns false when WP_INSTALLING is not defined')]
    public function isInstallingReturnsFalseWhenWpInstallingIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isInstalling());
    }

    #[Test]
    #[TestDox('isMultisite() returns false when MULTISITE is not defined')]
    public function isMultisiteReturnsFalseWhenMultisiteIsNotDefined(): void
    {
        $this->assertFalse($this->subject->isMultisite());
    }
}

<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

use SolarPoint\Core\Tests\Stubs\WordPress;

$autoloader = dirname(__DIR__).'/vendor/autoload.php';

if (file_exists($autoloader)) {
    require_once $autoloader;
}

if (!function_exists('wp_get_environment_type')) {
    function wp_get_environment_type(): string
    {
        return WordPress::$environmentType;
    }
}

if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}

if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}

if (!defined('SCRIPT_DEBUG')) {
    define('SCRIPT_DEBUG', false);
}

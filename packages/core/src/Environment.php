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
 * Provides access to the current WordPress runtime environment.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
final class Environment
{
    /**
     * The resolved environment type instance for the current runtime.
     */
    private ?EnvironmentType $type = null;

    /**
     * Returns the current environment type.
     *
     * @return EnvironmentType The current environment type.
     */
    public function type(): EnvironmentType
    {
        return $this->type ??= EnvironmentType::from(
            \function_exists('wp_get_environment_type')
                ? wp_get_environment_type()
                : 'production'
        );
    }

    /**
     * Determines whether the current environment is production.
     *
     * @return bool True if the environment type is production, false otherwise.
     */
    public function isProduction(): bool
    {
        return $this->type() === EnvironmentType::Production;
    }

    /**
     * Determines whether the current environment is staging.
     *
     * @return bool True if the environment type is staging, false otherwise.
     */
    public function isStaging(): bool
    {
        return $this->type() === EnvironmentType::Staging;
    }

    /**
     * Determines whether the current environment is development.
     *
     * @return bool True if the environment type is development, false otherwise.
     */
    public function isDevelopment(): bool
    {
        return $this->type() === EnvironmentType::Development;
    }

    /**
     * Determines whether the current environment is local.
     *
     * @return bool True if the environment type is local, false otherwise.
     */
    public function isLocal(): bool
    {
        return $this->type() === EnvironmentType::Local;
    }

    /**
     * Determines whether debug mode is enabled.
     *
     * @return bool True if WP_DEBUG is defined and true, false otherwise.
     */
    public function isDebug(): bool
    {
        return \defined('WP_DEBUG') && WP_DEBUG;
    }

    /**
     * Determines whether debug output is displayed on screen.
     *
     * @return bool True if WP_DEBUG_DISPLAY is defined and true, false otherwise.
     */
    public function isDebugDisplay(): bool
    {
        return \defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY;
    }

    /**
     * Determines whether debug logging is enabled.
     *
     * WP_DEBUG_LOG may be set to a file path string instead of a boolean.
     * A non-empty string is treated as true.
     *
     * @return bool True if WP_DEBUG_LOG is defined and truthy, false otherwise.
     */
    public function isDebugLog(): bool
    {
        return \defined('WP_DEBUG_LOG') && WP_DEBUG_LOG;
    }

    /**
     * Determines whether script debug mode is enabled.
     *
     * @return bool True if SCRIPT_DEBUG is defined and true, false otherwise.
     */
    public function isScriptDebug(): bool
    {
        return \defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
    }

    /**
     * Determines whether the current request is for the WordPress admin area.
     *
     * @return bool True if WP_ADMIN is defined and true, false otherwise.
     */
    public function isAdmin(): bool
    {
        return \defined('WP_ADMIN') && WP_ADMIN;
    }

    /**
     * Determines whether the current request is an AJAX request.
     *
     * @return bool True if DOING_AJAX is defined and true, false otherwise.
     */
    public function isAjax(): bool
    {
        return \defined('DOING_AJAX') && DOING_AJAX;
    }

    /**
     * Determines whether WordPress is running via the command line (WP-CLI).
     *
     * @return bool True if WP_CLI is defined and true, false otherwise.
     */
    public function isCli(): bool
    {
        return \defined('WP_CLI') && WP_CLI;
    }

    /**
     * Determines whether WordPress is currently running a cron job.
     *
     * @return bool True if DOING_CRON is defined and true, false otherwise.
     */
    public function isCron(): bool
    {
        return \defined('DOING_CRON') && DOING_CRON;
    }

    /**
     * Determines whether the current request is a REST API request.
     *
     * @return bool True if REST_REQUEST is defined and true, false otherwise.
     */
    public function isRest(): bool
    {
        return \defined('REST_REQUEST') && REST_REQUEST;
    }

    /**
     * Determines whether the current request is an XML-RPC request.
     *
     * @return bool True if XMLRPC_REQUEST is defined and true, false otherwise.
     */
    public function isXmlRpc(): bool
    {
        return \defined('XMLRPC_REQUEST') && XMLRPC_REQUEST;
    }

    /**
     * Determines whether WordPress is currently importing data.
     *
     * @return bool True if WP_IMPORTING is defined and true, false otherwise.
     */
    public function isImporting(): bool
    {
        return \defined('WP_IMPORTING') && WP_IMPORTING;
    }

    /**
     * Determines whether WordPress is currently being installed.
     *
     * @return bool True if WP_INSTALLING is defined and true, false otherwise.
     */
    public function isInstalling(): bool
    {
        return \defined('WP_INSTALLING') && WP_INSTALLING;
    }

    /**
     * Determines whether WordPress is running in multisite mode.
     *
     * @return bool True if MULTISITE is defined and true, false otherwise.
     */
    public function isMultisite(): bool
    {
        return \defined('MULTISITE') && MULTISITE;
    }
}

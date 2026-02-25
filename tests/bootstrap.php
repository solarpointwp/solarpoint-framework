<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

foreach (glob(__DIR__.'/../packages/*/tests/bootstrap.php') as $bootstrap) {
    require_once $bootstrap;
}

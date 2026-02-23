<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\Exceptions;

/**
 * This exception is thrown when a circular dependency is detected while resolving a service.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class ServiceCircularReferenceException extends RuntimeException
{
}

<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\Exceptions;

/**
 * Base class for runtime exceptions in the SolarPoint Container component.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
}

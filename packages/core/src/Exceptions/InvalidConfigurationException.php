<?php

/**
 * This file is part of the SolarPoint framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Core\Exceptions;

/**
 * Thrown when a configuration file returns a value that is not an object.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class InvalidConfigurationException extends LogicException
{
}

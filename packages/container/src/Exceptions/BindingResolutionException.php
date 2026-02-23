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
 * This exception is thrown when a binding cannot be resolved, either because it is not registered or because its concrete class does not exist.
 *
 * @author Mark Hadjar <mark.hadjar@solarpointwp.com>
 */
class BindingResolutionException extends RuntimeException
{
}

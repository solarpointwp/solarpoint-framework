<?php

declare(strict_types=1);

use SolarPoint\Core\Tests\Fixtures\ServiceProviders\ServiceProviderSpy;

return [
    ServiceProviderSpy::class,
    123,
    'NonExistent\ClassName\ThatDoesNotExist',
];

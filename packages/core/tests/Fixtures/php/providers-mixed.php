<?php

declare(strict_types=1);
use SolarPoint\Core\Tests\Fixtures\ServiceProviderSpy;

return [
    ServiceProviderSpy::class,
    123,
    'NonExistent\ClassName\ThatDoesNotExist',
];

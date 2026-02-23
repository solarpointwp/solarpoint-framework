<?php

/**
 * This file is part of the SolarPointWP framework.
 *
 * Copyright (c) 2026 Mark Hadjar <mark.hadjar@solarpointwp.com>
 *
 * For the full copyright and license information, please see the included LICENSE file.
 */

declare(strict_types=1);

namespace SolarPoint\Container\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use SolarPoint\Container\Container;
use SolarPoint\Container\ContainerInterface;
use SolarPoint\Container\Exceptions\BindingResolutionException;
use SolarPoint\Container\Exceptions\ServiceCircularReferenceException;
use SolarPoint\Container\Tests\Fixtures\CircularA;
use SolarPoint\Container\Tests\Fixtures\CircularB;
use SolarPoint\Container\Tests\Fixtures\CircularC;
use SolarPoint\Container\Tests\Fixtures\ConcreteWithPrimitiveArguments;
use SolarPoint\Container\Tests\Fixtures\ServiceImplementation;
use SolarPoint\Container\Tests\Fixtures\ServiceInterface;
use SolarPoint\Container\Tests\Fixtures\ServiceStub;

/**
 * @internal
 */
#[CoversClass(Container::class)]
final class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    protected function tearDown(): void
    {
        unset($this->container);
    }

    // =========================================================
    // Contract
    // =========================================================

    #[Test]
    #[TestDox('Container implements ContainerInterface')]
    public function containerImplementsContainerInterface(): void
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
    }

    // =========================================================
    // bind()
    // =========================================================

    #[Test]
    #[TestDox('bind() resolves a self-bound class when no concrete is specified')]
    public function bindResolvesASelfBoundClass(): void
    {
        $this->container->bind(ServiceStub::class);

        $result = $this->container->make(ServiceStub::class);

        $this->assertInstanceOf(ServiceStub::class, $result);
    }

    #[Test]
    #[TestDox('bind() resolves an interface bound to a concrete class string')]
    public function bindResolvesAnInterfaceBoundToAConcreteClassString(): void
    {
        $this->container->bind(ServiceInterface::class, ServiceImplementation::class);

        $result = $this->container->make(ServiceInterface::class);

        $this->assertInstanceOf(ServiceImplementation::class, $result);
    }

    #[Test]
    #[TestDox('bind() resolves an interface to an already-bound concrete class')]
    public function bindResolvesAnInterfaceToAnAlreadyBoundConcreteClass(): void
    {
        $this->container->singleton(ServiceImplementation::class);
        $this->container->bind(ServiceInterface::class, ServiceImplementation::class);

        $first = $this->container->make(ServiceInterface::class);
        $second = $this->container->make(ServiceInterface::class);

        $this->assertInstanceOf(ServiceImplementation::class, $first);
        $this->assertSame($first, $second);
    }

    #[Test]
    #[TestDox('bind() resolves a class bound to a factory closure')]
    public function bindResolvesAClassBoundToAFactoryClosure(): void
    {
        $this->container->bind(ServiceStub::class, fn () => new ServiceStub());

        $result = $this->container->make(ServiceStub::class);

        $this->assertInstanceOf(ServiceStub::class, $result);
    }

    #[Test]
    #[TestDox('bind() creates a new instance on each resolution')]
    public function bindCreatesANewInstanceOnEachResolution(): void
    {
        $this->container->bind(ServiceStub::class);

        $first = $this->container->make(ServiceStub::class);
        $second = $this->container->make(ServiceStub::class);

        $this->assertNotSame($first, $second);
    }

    #[Test]
    #[TestDox('bind() replaces the previous binding')]
    public function bindReplacesThePreviousBinding(): void
    {
        $this->container->bind(ServiceStub::class);

        $rebound = false;
        $this->container->bind(ServiceStub::class, function () use (&$rebound): ServiceStub {
            $rebound = true;

            return new ServiceStub();
        });

        $this->container->make(ServiceStub::class);

        $this->assertTrue($rebound);
    }

    #[Test]
    #[TestDox('bind() changes shared state to non-shared when rebinding a singleton')]
    public function bindChangesSharedStateToNonShared(): void
    {
        $this->container->singleton(ServiceStub::class);
        $this->assertTrue($this->container->isShared(ServiceStub::class));

        $this->container->bind(ServiceStub::class);

        $this->assertFalse($this->container->isShared(ServiceStub::class));
    }

    #[Test]
    #[TestDox('bind() drops the cached shared instance when rebinding a singleton')]
    public function bindDropsTheCachedSharedInstance(): void
    {
        $this->container->singleton(ServiceStub::class);
        $cached = $this->container->make(ServiceStub::class);

        $this->container->bind(ServiceStub::class);
        $fresh = $this->container->make(ServiceStub::class);

        $this->assertNotSame($cached, $fresh);
    }

    // =========================================================
    // singleton()
    // =========================================================

    #[Test]
    #[TestDox('singleton() returns the same instance on every resolution')]
    public function singletonReturnsTheSameInstanceOnEveryResolution(): void
    {
        $this->container->singleton(ServiceStub::class);

        $first = $this->container->make(ServiceStub::class);
        $second = $this->container->make(ServiceStub::class);

        $this->assertSame($first, $second);
    }

    #[Test]
    #[TestDox('singleton() differs from bind() which creates a new instance each time')]
    public function singletonDiffersFromBindWhichCreatesANewInstanceEachTime(): void
    {
        $this->container->bind(ServiceStub::class);

        $first = $this->container->make(ServiceStub::class);
        $second = $this->container->make(ServiceStub::class);

        $this->assertNotSame($first, $second);
    }

    #[Test]
    #[TestDox('singleton() with a class string resolves the correct concrete and caches the instance')]
    public function singletonWithClassStringResolvesConcreteAndCachesInstance(): void
    {
        $this->container->singleton(ServiceInterface::class, ServiceImplementation::class);

        $first = $this->container->make(ServiceInterface::class);
        $second = $this->container->make(ServiceInterface::class);

        $this->assertInstanceOf(ServiceImplementation::class, $first);
        $this->assertSame($first, $second);
    }

    #[Test]
    #[TestDox('singleton() with a factory closure resolves and caches the instance')]
    public function singletonWithClosureResolvesAndCachesInstance(): void
    {
        $this->container->singleton(ServiceInterface::class, fn () => new ServiceImplementation());

        $first = $this->container->make(ServiceInterface::class);
        $second = $this->container->make(ServiceInterface::class);

        $this->assertInstanceOf(ServiceImplementation::class, $first);
        $this->assertSame($first, $second);
    }

    #[Test]
    #[TestDox('singleton() factory closure executes only once regardless of how many times make() is called')]
    public function singletonFactoryClosureExecutesOnlyOnce(): void
    {
        $count = 0;
        $this->container->singleton(ServiceStub::class, function () use (&$count): ServiceStub {
            ++$count;

            return new ServiceStub();
        });

        $this->container->make(ServiceStub::class);
        $this->container->make(ServiceStub::class);
        $this->container->make(ServiceStub::class);

        $this->assertSame(1, $count);
    }

    // =========================================================
    // instance()
    // =========================================================

    #[Test]
    #[TestDox('instance() returns the registered object directly')]
    public function instanceReturnsTheRegisteredObjectDirectly(): void
    {
        $stub = new ServiceStub();
        $this->container->instance(ServiceStub::class, $stub);

        $result = $this->container->make(ServiceStub::class);

        $this->assertSame($stub, $result);
    }

    #[Test]
    #[TestDox('instance() always returns the same object reference')]
    public function instanceAlwaysReturnsTheSameObjectReference(): void
    {
        $this->container->instance(ServiceStub::class, new ServiceStub());

        $first = $this->container->make(ServiceStub::class);
        $second = $this->container->make(ServiceStub::class);

        $this->assertSame($first, $second);
    }

    #[Test]
    #[TestDox('instance() overrides an existing bind() registration')]
    public function instanceOverridesPreviousBinding(): void
    {
        $this->container->bind(ServiceStub::class);

        $override = new ServiceStub();
        $this->container->instance(ServiceStub::class, $override);

        $this->assertSame($override, $this->container->make(ServiceStub::class));
    }

    // =========================================================
    // make()
    // =========================================================

    #[Test]
    #[TestDox('make() passes parameters to closure bindings')]
    public function makePassesParametersToClosureBindings(): void
    {
        $this->container->bind(
            ConcreteWithPrimitiveArguments::class,
            function (Container $c, array $parameters): ConcreteWithPrimitiveArguments {
                /** @var string $name */
                $name = $parameters['name'];

                /** @var int $value */
                $value = $parameters['value'];

                return new ConcreteWithPrimitiveArguments($name, $value);
            },
        );

        $result = $this->container->make(ConcreteWithPrimitiveArguments::class, ['name' => 'custom', 'value' => 99]);

        $this->assertSame('custom', $result->name);
        $this->assertSame(99, $result->value);
    }

    #[Test]
    #[TestDox('make() passes constructor parameters to a resolved class')]
    public function makePassesConstructorParametersToResolvedClass(): void
    {
        $this->container->bind(ConcreteWithPrimitiveArguments::class);

        $result = $this->container->make(ConcreteWithPrimitiveArguments::class, ['name' => 'test', 'value' => 42]);

        $this->assertSame('test', $result->name);
        $this->assertSame(42, $result->value);
    }

    #[Test]
    #[TestDox('make() throws BindingResolutionException when the abstract is not bound')]
    public function makeThrowsBindingResolutionExceptionWhenAbstractIsNotBound(): void
    {
        $this->expectException(BindingResolutionException::class);

        $this->container->make(ServiceStub::class);
    }

    #[Test]
    #[TestDox('make() throws BindingResolutionException when the concrete class does not exist')]
    public function makeThrowsBindingResolutionExceptionWhenConcreteClassDoesNotExist(): void
    {
        $this->container->bind(ServiceStub::class, 'NonExistentClass');

        $this->expectException(BindingResolutionException::class);

        $this->container->make(ServiceStub::class);
    }

    #[Test]
    #[TestDox('make() throws ServiceCircularReferenceException on an immediate self-referential closure')]
    public function makeThrowsServiceCircularReferenceExceptionOnImmediateSelfReferentialClosure(): void
    {
        $this->container->bind(ServiceStub::class, fn (Container $c) => $c->make(ServiceStub::class));

        $this->expectException(ServiceCircularReferenceException::class);
        $this->expectExceptionMessageMatches('/ServiceStub/');

        $this->container->make(ServiceStub::class);
    }

    #[Test]
    #[TestDox('make() throws ServiceCircularReferenceException on a multi-class circular dependency')]
    public function makeThrowsServiceCircularReferenceExceptionOnCircularDependency(): void
    {
        // Explicit closures are required to trigger the $buildStack guard — the container
        // has no autowiring, so constructor dependencies alone are invisible to it.
        $this->container->bind(CircularA::class, fn (Container $c) => new CircularA($c->make(CircularB::class)));
        $this->container->bind(CircularB::class, fn (Container $c) => new CircularB($c->make(CircularC::class)));
        $this->container->bind(CircularC::class, fn (Container $c) => new CircularC($c->make(CircularA::class)));

        $this->expectException(ServiceCircularReferenceException::class);
        $this->expectExceptionMessageMatches(
            '/SolarPoint\\\Container\\\Tests\\\Fixtures\\\CircularA.*CircularB.*CircularC/',
        );

        $this->container->make(CircularA::class);
    }

    // =========================================================
    // bound()
    // =========================================================

    #[Test]
    #[TestDox('bound() returns true after bind()')]
    public function boundReturnsTrueAfterBind(): void
    {
        $this->container->bind(ServiceStub::class);

        $this->assertTrue($this->container->bound(ServiceStub::class));
    }

    #[Test]
    #[TestDox('bound() returns true after singleton()')]
    public function boundReturnsTrueAfterSingleton(): void
    {
        $this->container->singleton(ServiceStub::class);

        $this->assertTrue($this->container->bound(ServiceStub::class));
    }

    #[Test]
    #[TestDox('bound() returns true after instance()')]
    public function boundReturnsTrueAfterInstance(): void
    {
        $this->container->instance(ServiceStub::class, new ServiceStub());

        $this->assertTrue($this->container->bound(ServiceStub::class));
    }

    #[Test]
    #[TestDox('bound() returns false when nothing is registered')]
    public function boundReturnsFalseWhenNothingIsRegistered(): void
    {
        $this->assertFalse($this->container->bound(ServiceStub::class));
    }

    // =========================================================
    // isShared()
    // =========================================================

    #[Test]
    #[TestDox('isShared() returns true for a singleton binding')]
    public function isSharedReturnsTrueForSingletonBinding(): void
    {
        $this->container->singleton(ServiceStub::class);

        $this->assertTrue($this->container->isShared(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isShared() returns true for a registered instance')]
    public function isSharedReturnsTrueForRegisteredInstance(): void
    {
        $this->container->instance(ServiceStub::class, new ServiceStub());

        $this->assertTrue($this->container->isShared(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isShared() returns false for a non-shared binding')]
    public function isSharedReturnsFalseForNonSharedBinding(): void
    {
        $this->container->bind(ServiceStub::class);

        $this->assertFalse($this->container->isShared(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isShared() returns false for an unregistered abstract')]
    public function isSharedReturnsFalseForUnregisteredAbstract(): void
    {
        $this->assertFalse($this->container->isShared(ServiceStub::class));
    }

    // =========================================================
    // isResolved()
    // =========================================================

    #[Test]
    #[TestDox('isResolved() returns true for an instance binding before make() is called')]
    public function isResolvedReturnsTrueForInstanceBindingBeforeMakeIsCalled(): void
    {
        $this->container->instance(ServiceStub::class, new ServiceStub());

        $this->assertTrue($this->container->isResolved(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isResolved() returns true for an instance binding after make() is called')]
    public function isResolvedReturnsTrueForInstanceBindingAfterMakeIsCalled(): void
    {
        $this->container->instance(ServiceStub::class, new ServiceStub());

        $this->container->make(ServiceStub::class);

        $this->assertTrue($this->container->isResolved(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isResolved() returns true for a singleton after subsequent resolutions')]
    public function isResolvedReturnsTrueForSingletonAfterSubsequentResolutions(): void
    {
        $this->container->singleton(ServiceStub::class);
        $this->container->make(ServiceStub::class);
        $this->container->make(ServiceStub::class);

        $this->assertTrue($this->container->isResolved(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isResolved() returns false before make() is called')]
    public function isResolvedReturnsFalseBeforeMakeIsCalled(): void
    {
        $this->container->bind(ServiceStub::class);

        $this->assertFalse($this->container->isResolved(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isResolved() returns true after make() is called')]
    public function isResolvedReturnsTrueAfterMakeIsCalled(): void
    {
        $this->container->bind(ServiceStub::class);
        $this->container->make(ServiceStub::class);

        $this->assertTrue($this->container->isResolved(ServiceStub::class));
    }

    #[Test]
    #[TestDox('isResolved() returns false after flush()')]
    public function isResolvedReturnsFalseAfterFlush(): void
    {
        $this->container->bind(ServiceStub::class);
        $this->container->make(ServiceStub::class);
        $this->container->flush();

        $this->assertFalse($this->container->isResolved(ServiceStub::class));
    }

    // =========================================================
    // flush()
    // =========================================================

    #[Test]
    #[TestDox('flush() clears all bindings')]
    public function flushClearsAllBindings(): void
    {
        $this->container->bind(ServiceStub::class);

        $this->container->flush();

        $this->assertFalse($this->container->bound(ServiceStub::class));
    }

    #[Test]
    #[TestDox('flush() clears all shared instances')]
    public function flushClearsAllSharedInstances(): void
    {
        $this->container->instance(ServiceStub::class, new ServiceStub());

        $this->container->flush();

        $this->assertFalse($this->container->bound(ServiceStub::class));
    }

    #[Test]
    #[TestDox('flush() clears resolved state')]
    public function flushClearsResolvedState(): void
    {
        $this->container->bind(ServiceStub::class);
        $this->container->make(ServiceStub::class);

        $this->container->flush();

        $this->assertFalse($this->container->isResolved(ServiceStub::class));
    }

    // =========================================================
    // Re-registration
    // =========================================================

    #[Test]
    #[TestDox('singleton() overrides an existing bind() and makes the binding shared')]
    public function singletonOverridesExistingBind(): void
    {
        $this->container->bind(ServiceStub::class);

        $this->container->singleton(ServiceStub::class);

        $first = $this->container->make(ServiceStub::class);
        $second = $this->container->make(ServiceStub::class);

        $this->assertSame($first, $second);
    }
}

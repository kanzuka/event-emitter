# Event Emitter

[![@icicleio on Twitter](https://img.shields.io/badge/twitter-%40icicleio-5189c7.svg?style=flat-square)](https://twitter.com/icicleio)
[![Build Status](https://img.shields.io/travis/icicleio/EventEmitter/master.svg?style=flat-square)](https://travis-ci.org/icicleio/EventEmitter)
[![Coverage Status](https://img.shields.io/coveralls/icicleio/EventEmitter.svg?style=flat-square)](https://coveralls.io/r/icicleio/EventEmitter)
[![Semantic Version](https://img.shields.io/badge/semver-v1.0.0-yellow.svg?style=flat-square)](http://semver.org)
[![Apache 2 License](https://img.shields.io/packagist/l/icicleio/event-emitter.svg?style=flat-square)](LICENSE)

[![Join the chat at https://gitter.im/icicleio/Icicle](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/icicleio/Icicle)

Event emitters are objects that can create a set of events identified by an integer or string to which other code can register callbacks that are invoked when the event occurs. Each event emitter should implement `Icicle\EventEmitter\EventEmitterInterface`, which can be done easily by using `Icicle\EventEmitter\EventEmitterTrait` in the class definition.

This implementation differs from other event emitter libraries by ensuring that a particular callback can only be registered once for a particular event identifier. An attempt to register a previously registered callback is a no-op.

Event identifiers are also strictly enforced to aid in debugging. Event emitter objects must initialize event identifiers of events they wish to emit. If an attempt to register a callback is made on a non-existent event, a `Icicle\EventEmitter\Exception\InvalidEventException` is thrown.

##### Example

```php
use Icicle\EventEmitter\EventEmitterInterface;
use Icicle\EventEmitter\EventEmitterTrait;

class ExampleEventEmitter implements EventEmitterInterface
{
    use EventEmitterTrait;
    
    public function __construct()
    {
        $this->createEvent('action'); // Creates event with 'action' identifier.
    }
    
    public function doAction($arg1, $arg2)
    {
        $this->emit('action', $arg1, $arg2); // Emits an event with 'action' identifier.
    }
}
```
The example class above implements `Icicle\EventEmitter\EventEmitterInterface` so it can emit events to a set of listeners. The example below demonstrates how listeners can be added to an instance of this class and the behavior of emitting events. This class will also be used in several other examples below.

```php
$emitter = new ExampleEventEmitter();

// Registers a callback to be called each time the event is emitted.
$emitter->on('action', function ($arg1, $arg2) {
    echo "Argument 1 value: {$arg1}\n";
    echo "Argument 2 value: {$arg2}\n";
});

// Registers a callback to be called only the next time the event is emitted.
$emitter->once('action', function ($arg1, $arg2) {
    $result = $arg1 * $arg2;
    echo "Result: {$result}\n";
});

$emitter->doAction(404, 3.14159); // Calls both functions above.
$emitter->doAction(200, 2.71828); // Calls only the first function.
```

##### Requirements

- PHP 5.4+

##### Installation

The recommended way to install is with the [Composer](http://getcomposer.org/) package manager. (See the [Composer installation guide](https://getcomposer.org/doc/00-intro.md) for information on installing and using Composer.)

Run the following command to use this library in your project: 

```bash
composer require icicleio/event-emitter ~1
```

You can also manually edit `composer.json` to add this library as a project requirement.

```js
// composer.json
{
    "require": {
        "icicleio/event-emitter": "~1"
    }
}
```

## Documentation

- [EventEmitterInterface](#eventemitterinterface)
    - [addListener()](#addlistener) - Adds an event listener.
    - [on()](#on) - Adds an event listener called each time an event is emitted.
    - [once()](#once) - Adds an event listener called only the next time an event is emitted.
    - [removeListener()](#removeListener) - Removes an event listener.
    - [off()](#off) - Removes an event listener.
    - [removeAllListeners()](#removealllisteners) - Removes all listeners from an identifier or all identifiers.
    - [getListeners()](#getlisteners) - Returns the set of listeners for an event identifier.
    - [getListenerCount()](#getlistenercount) - Returns the number of listeners on an event identifier.
    - [emit()](#emit) - Emit an event.
- [EventEmitterTrait](#eventemittertrait)
    - [createEvent()](#createevent) - Creates an event identifier.
- [Using Promises with Event Emitters](#using-promises-with-event-emitters)
- [Using Coroutines with Event Emitters](#using-coroutines-with-event-emitters)

#### Function prototypes

Prototypes for object instance methods are described below using the following syntax:

```php
ReturnType $classOrInterfaceName->methodName(ArgumentType $arg1, ArgumentType $arg2)
```

Prototypes for static methods are described below using the following syntax:

```php
ReturnType ClassName::methodName(ArgumentType $arg1, ArgumentType $arg2)
```

To document the expected prototype of a callback function used as method arguments or return types, the documentation below uses the following syntax for `callable` types:

```php
callable<ReturnType (ArgumentType $arg1, ArgumentType $arg2)>
```

## EventEmitterInterface

`Icicle\EventEmitter\EventEmitterInterface` is an interface that any class can implement for emitting events. The simplest way to implement this interface is to use `Icicle\EventEmitter\EventEmitterTrait` in the class definition or for the class to extend `Icicle\EventEmitter\EventEmitter`.

#### addListener()

```php
$this $eventListenerInterface->addListener(
    string|int $event,
    callable<void (mixed ...$args)> $callback,
    bool $once = false
)
```

Adds an event listener defined by `$callback` to the event identifier `$event`. If `$once` is `true`, the listener will only be called the next time the event is emitted, otherwise the listener will be called each time the event is emitted. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

---

#### on()

```php
$this $eventListenerInterface->on(string|int $event, callable<void (mixed ...$args)> $callback)
```

Adds an event listener defined by `$callback` to the event identifier `$event` that will be called each time the event is emitted. This method is identical to calling `addListener()` with `$once` as `false`. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

---

#### once()

```php
$this $eventListenerInterface->once(string|int $event, callable<void (mixed ...$args)> $callback)
```

Adds an event listener defined by `$callback` to the event identifier `$event` that will be only the next time the event is emitted. This method is identical to calling `addListener()` with `$once` as `true`. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

---

#### removeListener()

```php
$this $eventListenerInterface->removeListener(string|int $event, callable<void (mixed ...$args)> $callback)
```

Removes the event listener defined by `$callback` from the event identifier `$event`. This method will remove the listener regardless of if the listener was to be called each time the event was emitted or only the next time the event was emitted. If the was not a registered on the given event, this function is a no-op. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

---

#### off()

```php
$this $eventListenerInterface->off(string|int $event, callable<void (mixed ...$args)> $callback)
```

This method is an alias of `removeListener()`.

---

#### removeAllListeners()

```php
$this $eventListenerInterface->removeAllListeners(string|int|null $event = null)
```

Removes all listeners from the event identifier or if `$event` is `null`, removes all listeners from all events. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

---

#### getListeners()

```php
callable[] $eventListenerInterface->getListeners(string|int $event)
```

Returns all listeners on the event identifier as an array of callables. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

---

#### getListenerCount()

```php
int $eventListenerInterface->getListenerCount(string|int $event)
```

Gets the number of listeners on the event identifier. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

## EventEmitterTrait

`Icicle\EventEmitter\EventEmitterTrait` is a simple way for any class to implement `Icicle\EventEmitter\EventEmitterInterface`. This trait defines protected methods that are not part of `Icicle\EventEmitter\EventEmitterInterface` that are used to create and emit events.

#### createEvent()

```php
$this $eventEmitterTrait->create(string|int $identifier)
```

This method creates an event identifier so events may be emitted and listeners added. Generally this method will be called in the constructor to initialize a set of event identifiers.

---

#### emit()

```php
bool $eventListenerInterface->emit(string|int $event, mixed ...$args)
```

Emits an event with the event identifier `$event`, passing the remaining arguments given to this function as the arguments to each event listener. The method returns `true` if any event listeners were invoked, `false` if none were. If the identifier given by `$event` does not exist, an `Icicle\EventEmitter\Exception\InvalidEventException` will be thrown.

## Using Promises with Event Emitters

[Promises](//github.com/icicleio/Icicle/tree/master/src/Promise) are part of the [Icicle](//github.com/icicleio/Icicle) library for writing asynchronous code in PHP. Promises act as placeholders for the future value of an asynchronous operation.

The static method `Icicle\Promise\Promise::promisify()` can be used to create a function returning a promise that is resolved the next time an event emitter emits an event.

```php
use Icicle\Loop\Loop;
use Icicle\Promise\Promise;

// Include ExampleEventEmitter class definition from above.

$emitter = new ExampleEventEmitter();

// Use once() since promises can only be resolved once.
$promisor = Promise::promisify([$emitter, 'once'], 1);

$promise = $promisor('action'); // Promise for 'action' event.

$promise = $promise->then(function (array $args) {
    list($arg1, $arg2) = $args;
    echo "Argument 1 value: {$arg1}\n";
    echo "Argument 2 value: {$arg2}\n";
});

// Simulates an event being emitted while running the loop.
Loop::schedule(function () use ($emitter) {
    $emitter->doAction(404, 3.14159); // Fulfills promise.
});

Loop::run();
```

See the [Promise API documentation](//github.com/icicleio/Icicle/tree/master/src/Promise) for more information on using promises.

## Using Coroutines with Event Emitters

[Coroutines](//github.com/icicleio/Icicle/tree/master/src/Coroutine) use generators to create cooperative coroutines. They are a component of the [Icicle](//github.com/icicleio/Icicle) library for writing asynchronous code in PHP.

Event emitters can be used to create and execute coroutines each time an event is emitted. The static method `Icicle\Coroutine\Coroutine::async()` returns a function that can be used as the event listener on an event emitter.

```php
use Icicle\Coroutine\Coroutine;
use Icicle\Loop\Loop;

// Include ExampleEventEmitter class definition from above.

$emitter = new ExampleEventEmitter();

$emitter->on('action', Coroutine::async(function ($arg1, $arg2) {
    $result = (yield $arg1 * $arg2);
    echo "Result: {$result}\n";
}));

// Simulates an event being emitted while running the loop.
Loop::schedule(function () use ($emitter) {
    $emitter->doAction(404, 3.14159); // Creates and runs coroutine.
});

Loop::run();
```

See the [Coroutine API documentation](//github.com/icicleio/Icicle/tree/master/src/Coroutine) for more information on using coroutines.

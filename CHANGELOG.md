# Changelog

### v1.1.0

- Added methods to determine what events an object emits:
    - `bool emits(string|int $event)` - Determines if the object emits events with the identifier given by `$event`.
    - `array getEventList()` - Returns an array of event identifiers emitted by the object.

---

### v1.0.0

- Changed `emit()` method to protected and removed from interface. Classes wishing to expose `emit()` publicly can use `emit as public` when using `Icicle\EventEmitter\EventEmitterTrait`.

---

### v0.1.0

- Initial release, separated from [Icicle](//github.com/icicleio/Icicle) repository.

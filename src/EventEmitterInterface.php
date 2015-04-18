<?php
namespace Icicle\EventEmitter;

interface EventEmitterInterface
{
    /**
     * Adds a listener function that is called each time the event is emitted.
     *
     * @param   string|int $event Event identifier.
     * @param   callable $listener Function to invoke when the event is emitted.
     * @param   bool $once Set to true for the listener to be called only the next time the event is emitted.
     *
     * @return  $this
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function addListener($event, callable $listener, $once = false);
    
    /**
     * Alias of addListener() without the $once parameter.
     *
     * @see     \Icicle\EventEmitter\EventEmitterInterface::addListener()
     *
     * @param   string|int $event Event identifier.
     * @param   callable $listener Function to invoke when the event is emitted.
     *
     * @return  $this
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function on($event, callable $listener);
    
    /**
     * Adds a one time listener that is called only the next time the event is emitted. Alias of
     * addListener() with the $once parameter set to true.
     *
     * @see     \Icicle\EventEmitter\EventEmitterInterface::addListener()
     *
     * @param   string|int $event Event identifier.
     * @param   callable $listener Function to invoke when the event is emitted.
     *
     * @return  $this
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function once($event, callable $listener);
    
    /**
     * Removes the listener from the event.
     *
     * @param   string|int $event Event identifier.
     * @param   callable $listener Function to remove.
     *
     * @return  $this
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function removeListener($event, callable $listener);
    
    /**
     * Alias of removeListener().
     *
     * @see     \Icicle\EventEmitter\EventEmitterInterface::removeListener()
     *
     * @param   string|int $event Event identifier.
     * @param   callable $listener Function to remove.
     *
     * @return  $this
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function off($event, callable $listener);
    
    /**
     * Removes all listeners from the event or all events if no event is given.
     *
     * @param   string|int|null $event Event identifier or null to remove all event listeners.
     *
     * @return  $this
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function removeAllListeners($event = null);
    
    /**
     * Returns all listeners for the event.
     *
     * @param   string|int $event Event identifier.
     *
     * @return  callable[] Array of event listeners.
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function getListeners($event);
    
    /**
     * Determines the number of listeners on an event.
     *
     * @param   string $event Event identifier.
     *
     * @return  int Number of listeners defined.
     *
     * @throws  \Icicle\EventEmitter\Exception\InvalidEventException If the event name does not exist.
     *
     * @api
     */
    public function getListenerCount($event);

    /**
     * Determines if the object emits events using the given event identifier.
     *
     * @param   string|int $event Event identifier.
     *
     * @return  bool
     */
    public function emits($event);

    /**
     * Returns an array of defined event identifiers.
     *
     * @return  array
     */
    public function getEventList();
}

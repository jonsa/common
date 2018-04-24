<?php
/**
 * This file is part of the prooph/common.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Prooph\Common\Event;

/**
 * An action event dispatcher dispatches ActionEvents which are mutable objects used as a communication mechanism
 * between ActionEventListeners listening on the same event and performing actions based on it.
 */
interface ActionEventEmitter
{
    /**
     * @param null|string $name of the action event
     * @param string|object $target of the action event
     * @param null|array|\ArrayAccess $params with which the event is initialized
     *
     * @return ActionEvent that can be triggered by the ActionEventEmitter
     */
    public function getNewActionEvent($name = null, $target = null, $params = null);

    public function dispatch(ActionEvent $event);

    /**
     * Trigger an event until the given callback returns a boolean true
     *
     * The callback is invoked after each listener and gets the action event as only argument
     */
    public function dispatchUntil(ActionEvent $event, callable $callback);

    public function attachListener($event, callable $listener, $priority = 1);

    public function detachListener(ListenerHandler $listenerHandler);

    public function attachListenerAggregate(ActionEventListenerAggregate $aggregate);

    public function detachListenerAggregate(ActionEventListenerAggregate $aggregate);
}

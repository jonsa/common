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
 * An action event is mutable object used as a communication mechanism for ActionEventListeners listening on the same
 * event and performing actions based on the event and its current state.
 */
interface ActionEvent
{
    public function getName();

    /**
     * Get target/context from which event was triggered
     *
     * @return null|string|object
     */
    public function getTarget();

    /**
     * Get parameters passed to the event
     *
     * @return array|\ArrayAccess
     */
    public function getParams();

    /**
     * Get a single parameter by name
     *
     * @param  string $name
     * @param  mixed $default Default value to return if parameter does not exist
     *
     * @return mixed
     */
    public function getParam($name, $default = null);

    public function setName($name);

    /**
     * Set the event target/context
     *
     * @param  null|string|object $target
     *
     * @return void
     */
    public function setTarget($target);

    /**
     * Set event parameters
     *
     * @param  array|\ArrayAccess $params
     *
     * @return void
     */
    public function setParams($params);

    /**
     * Set a single parameter by key
     *
     * @param  string $name
     * @param  mixed $value
     *
     * @return void
     */
    public function setParam($name, $value);

    /**
     * Indicate whether or not the parent ActionEventEmitter should stop propagating events
     *
     * @param  bool $flag
     *
     * @return void
     */
    public function stopPropagation($flag = true);

    /**
     * Has this event indicated event propagation should stop?
     */
    public function propagationIsStopped();
}

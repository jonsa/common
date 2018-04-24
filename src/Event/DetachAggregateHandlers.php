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
 * Trait to centralize logic of keeping track of registered ListenerHandlers of a ActionEventListenerAggregate and
 * to simplify detaching a ActionEventListenerAggregate.
 */
trait DetachAggregateHandlers
{
    /**
     * @var ListenerHandler[]
     */
    private $handlerCollection = [];

    protected function trackHandler(ListenerHandler $handler)
    {
        $this->handlerCollection[] = $handler;
    }

    public function detach(ActionEventEmitter $dispatcher)
    {
        foreach ($this->handlerCollection as $handler) {
            $dispatcher->detachListener($handler);
        }
    }
}

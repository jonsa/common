<?php
/**
 * This file is part of the prooph/common.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Prooph\Common\Messaging;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

interface Message extends HasMessageName
{
    const TYPE_COMMAND = 'command';
    const TYPE_EVENT = 'event';
    const TYPE_QUERY = 'query';

    /**
     * Should be one of Message::TYPE_COMMAND, Message::TYPE_EVENT or Message::TYPE_QUERY
     */
    public function messageType();

    public function uuid();

    public function createdAt();

    public function payload();

    public function metadata();

    public function withMetadata(array $metadata);

    /**
     * Returns new instance of message with $key => $value added to metadata
     *
     * Given value must have a scalar or array type.
     */
    public function withAddedMetadata($key, $value);
}

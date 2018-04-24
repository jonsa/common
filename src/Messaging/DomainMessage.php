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

use Assert\Assertion;
use DateTimeImmutable;
use DateTimeZone;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Base class for commands, domain events and queries. All are messages but differ in their intention.
 */
abstract class DomainMessage implements Message
{
    /**
     * @var string
     */
    protected $messageName;

    /**
     * @var UuidInterface
     */
    protected $uuid;

    /**
     * @var DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var array
     */
    protected $metadata = [];

    abstract protected function setPayload(array $payload);

    public static function fromArray(array $messageData)
    {
        MessageDataAssertion::assert($messageData);

        $messageRef = new \ReflectionClass(get_called_class());

        /** @var $message DomainMessage */
        $message = $messageRef->newInstanceWithoutConstructor();

        $message->uuid = Uuid::fromString($messageData['uuid']);
        $message->messageName = $messageData['message_name'];
        $message->metadata = $messageData['metadata'];
        $message->createdAt = $messageData['created_at'];
        $message->setPayload($messageData['payload']);

        return $message;
    }

    protected function init()
    {
        if ($this->uuid === null) {
            $this->uuid = Uuid::uuid4();
        }

        if ($this->messageName === null) {
            $this->messageName = get_class($this);
        }

        if ($this->createdAt === null) {
            $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        }
    }

    public function uuid()
    {
        return $this->uuid;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function metadata()
    {
        return $this->metadata;
    }

    public function toArray()
    {
        return [
            'message_name' => $this->messageName,
            'uuid' => $this->uuid->toString(),
            'payload' => $this->payload(),
            'metadata' => $this->metadata,
            'created_at' => $this->createdAt(),
        ];
    }

    public function messageName()
    {
        return $this->messageName;
    }

    public function withMetadata(array $metadata)
    {
        $message = clone $this;

        $message->metadata = $metadata;

        return $message;
    }

    /**
     * Returns new instance of message with $key => $value added to metadata
     *
     * Given value must have a scalar type.
     */
    public function withAddedMetadata($key, $value)
    {
        Assertion::notEmpty($key, 'Invalid key');

        $message = clone $this;

        $message->metadata[$key] = $value;

        return $message;
    }
}

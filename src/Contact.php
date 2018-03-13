<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

/**
 * Immutable contact person value object
 */
class Contact implements IdentityInterface, DateableInterface, CommentInterface
{
    use Traits\IdentityHashTrait, Traits\DateableTrait, Traits\CommentTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var AccountWrapper
     */
    private $account;

    /**
     * @var DataWrapper
     */
    private $mail;

    /**
     * @var DataWrapper Phone number container
     */
    private $phone;

    /**
     * @var boolean Flag if payouts should be allowed
     */
    private $isPayoutAllowed;

    public function __construct(
        string $name,
        AccountWrapper $account,
        DataWrapper $mail,
        DataWrapper $phone,
        bool $isPayoutAllowed,
        string $comment = '',
        string $identifier = '',
        \DateTimeImmutable $created = null,
        \DateTimeImmutable $updated = null
    ) {
        $this->name = $name;
        $this->account = $account;
        $this->mail = $mail;
        $this->phone = $phone;
        $this->isPayoutAllowed = $isPayoutAllowed;
        $this->setComment($comment);
        $this->setId($identifier);
        $this->setCreated($created);
        $this->setUpdated($updated);
    }

    /**
     * Get full name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get account object
     */
    public function getAccountWrapper(): AccountWrapper
    {
        return $this->account;
    }

    /**
     * Get mail object
     */
    public function getMailWrapper(): DataWrapper
    {
        return $this->mail;
    }

    /**
     * Get phone number
     */
    public function getPhoneWrapper(): DataWrapper
    {
        return $this->phone;
    }

    /**
     * Check if person currently is eligible for payouts
     */
    public function isPayoutAllowed(): bool
    {
        return $this->isPayoutAllowed;
    }

    /**
     * Get string to hash when creating id
     */
    protected function getHashable(): string
    {
        return $this->name . $this->getCreated()->getTimestamp();
    }
}

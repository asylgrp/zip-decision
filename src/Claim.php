<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\amount\Amount;

/**
 * A claim of funds issued by a contact person
 */
class Claim implements IdentityInterface, DateableInterface, CommentInterface
{
    use Traits\IdentityHashTrait, Traits\DateableTrait, Traits\CommentTrait;

    /**
     * @var Contact The contact making the claim
     */
    private $contact;

    /**
     * @var ?AccountWrapper Optional account number to use instead of contact person
     */
    private $account;

    /**
     * @var Amount Requested amount
     */
    private $requested;

    /**
     * @var Amount Approved amount
     */
    private $approved;

    public function __construct(
        Contact $contact,
        Amount $requested,
        AccountWrapper $account = null,
        string $comment = '',
        string $identifier = '',
        \DateTimeImmutable $created = null,
        \DateTimeImmutable $updated = null
    ) {
        $this->contact = $contact;
        $this->account = $account;
        $this->requested = $requested;
        $this->approved = $requested->subtract($requested);
        $this->setComment($comment);
        $this->setId($identifier);
        $this->setCreated($created);
        $this->setUpdated($updated);
    }

    /**
     * Get individual making this claim
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * Get account to use in this payout
     */
    public function getAccountWrapper(): AccountWrapper
    {
        return $this->account ?: $this->getContact()->getAccountWrapper();
    }

    /**
     * Get requested amount
     */
    public function getRequestedAmount(): Amount
    {
        return $this->requested;
    }

    /**
     * Get approved amount
     */
    public function getApprovedAmount(): Amount
    {
        return $this->approved;
    }

    /**
     * Get amount that has not been approved
     */
    public function getNotApprovedAmount(): Amount
    {
        return $this->getRequestedAmount()->subtract($this->getApprovedAmount());
    }

    /**
     * Approve some or all funds
     */
    public function approveAmount(Amount $amount): void
    {
        $this->approved = $this->approved->add($amount);

        if ($this->approved->isGreaterThan($this->requested)) {
            $this->approved = $this->requested;
        }
    }

    /**
     * Set the approved amount to a fixed level
     */
    public function setApprovedAmount(Amount $amount): void
    {
        $this->approved = $this->approved->subtract($this->approved);
        $this->approveAmount($amount);
    }

    /**
     * Get string to hash when creating id
     */
    protected function getHashable(): string
    {
        return $this->getContact()->getName()
            . $this->getRequestedAmount()
            . $this->getCreated()->getTimestamp()
            . rand(1000, 9999);
    }
}

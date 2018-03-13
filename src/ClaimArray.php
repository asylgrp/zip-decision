<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\amount\Amount;

/**
 * Wrapper around a set of claims
 */
class ClaimArray implements IdentityInterface, \Countable, \IteratorAggregate
{
    /**
     * Summarize over requested amounts
     */
    private const SUM_REQUESTED = 'getRequestedAmount';

    /**
     * Summarize over approved amounts
     */
    private const SUM_APPROVED = 'getApprovedAmount';

    /**
     * Summarize over not approved amounts
     */
    private const SUM_NOT_APPROVED = 'getNotApprovedAmount';

    /**
     * @var Claim[]
     */
    private $claims;

    public function __construct(Claim ...$claims)
    {
        $this->claims = $claims;
    }

    /**
     * Add claim to container
     */
    public function addClaim(Claim $claim): void
    {
        $this->claims[] = $claim;
    }

    /**
     * Get the first claim in container
     *
     * @throws \LogicException If container does not contain any claims
     */
    public function getFirstClaim(): Claim
    {
        if (empty($this->claims)) {
            throw new \LogicException("Trying to access first claim of empty claim array");
        }

        reset($this->claims);
        return current($this->claims);
    }

    /**
     * Count the set of claims
     *
     * Implements the Countable interface
     */
    public function count(): int
    {
        return count($this->claims);
    }

    /**
     * Get iterator for claims
     *
     * Implements the IteratorAggregate interface
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->claims);
    }

    /**
     * @deprecated Use getId() instead
     */
    public function getHash(): string
    {
        trigger_error("getHash() is deprecated, use getId() instead", E_USER_DEPRECATED);
        return $this->getId();
    }

    /**
     * Get a string identifying this unique set of claims
     */
    public function getId(): string
    {
        return substr(
            md5(
                array_reduce(
                    $this->claims,
                    function ($carry, Claim $claim) {
                        return $carry .= $claim->getContact()->getId()
                            . $claim->getRequestedAmount()
                            . $claim->getApprovedAmount()
                            . $claim->getCreated()->getTimestamp()
                            . $claim->getUpdated()->getTimestamp();
                    },
                    ''
                )
            ),
            0,
            10
        );
    }

    /**
     * Summarize claims over requested amounts
     */
    public function sumRequestedAmounts(): Amount
    {
        return $this->sum(self::SUM_REQUESTED);
    }

    /**
     * Summarize claims over approved amounts
     */
    public function sumApprovedAmounts(): Amount
    {
        return $this->sum(self::SUM_APPROVED);
    }

    /**
     * Summarize claims over not approved amounts
     */
    public function sumNotApprovedAmounts(): Amount
    {
        return $this->sum(self::SUM_NOT_APPROVED);
    }

    /**
     * Generic summarize (use one of the sum style constants)
     */
    private function sum(string $style): Amount
    {
        return array_reduce(
            $this->claims,
            function ($carry, Claim $claim) use ($style) {
                return $carry ? $carry->add($claim->$style()) : $claim->$style();
            }
        );
    }
}

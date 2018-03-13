<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\banking\AccountNumber;

/**
 * Container that wrapps a bank account with dates and a comment
 */
class AccountWrapper extends DataWrapper
{
    /**
     * @var AccountNumber
     */
    private $account;

    public function __construct(AccountNumber $account, string $comment = '', \DateTimeImmutable $updated = null)
    {
        parent::__construct((string)$account, $comment, $updated);
        $this->account = $account;
    }

    public function getAccount(): AccountNumber
    {
        return $this->account;
    }
}

<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\amount\Currency\SEK;

class ClaimTest extends \PHPUnit\Framework\TestCase
{
    private function createClaim(SEK &$amount = null, Contact &$contact = null, AccountWrapper &$account = null): Claim
    {
        $amount = $amount ?: new SEK('0');
        $account = $account ?: $this->prophesize(AccountWrapper::CLASS)->reveal();

        if (!$contact) {
            $contact = $this->prophesize(Contact::CLASS);
            $contact->getAccountWrapper()->willReturn($account);
            $contact = $contact->reveal();
        }

        return new Claim($contact, $amount, $account);
    }

    public function testGetters()
    {
        $claim = $this->createClaim($amount, $contact, $account);
        $this->assertEquals($contact, $claim->getContact());
        $this->assertEquals($amount, $claim->getRequestedAmount());
        $this->assertEquals($account, $claim->getAccountWrapper());
    }

    public function testGetAccountWrapper()
    {
        $claim = $this->createClaim($amount, $contact, $account);
        $this->assertEquals($account, $claim->getAccountWrapper());
    }

    public function testGenerateId()
    {
        $this->assertInternalType('string', $this->createClaim()->getId());
    }

    public function testDefaultApprovedAmount()
    {
        $this->assertEquals(new SEK('0'), $this->createClaim()->getApprovedAmount());
    }

    public function testApproveAmount()
    {
        $claimedAmount = new SEK('1000');
        $claim = $this->createClaim($claimedAmount);

        $claim->approveAmount(new SEK('10'));
        $this->assertEquals(new SEK('10'), $claim->getApprovedAmount());

        $claim->approveAmount(new SEK('10'));
        $this->assertEquals(new SEK('20'), $claim->getApprovedAmount());

        $claim->setApprovedAmount(new SEK('10'));
        $this->assertEquals(new SEK('10'), $claim->getApprovedAmount());
        $this->assertEquals(new SEK('990'), $claim->getNotApprovedAmount());
    }

    public function testApproveToMuch()
    {
        $claimedAmount = new SEK('1000');
        $claim = $this->createClaim($claimedAmount);
        $claim->approveAmount(new SEK('999999'));
        $this->assertEquals($claimedAmount, $claim->getApprovedAmount());
    }
}

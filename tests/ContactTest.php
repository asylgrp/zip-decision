<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

class ContactTest extends \PHPUnit\Framework\TestCase
{
    public function testGetters()
    {
        $account = $this->prophesize(AccountWrapper::CLASS)->reveal();
        $mail = $this->prophesize(DataWrapper::CLASS)->reveal();
        $phone = $this->prophesize(DataWrapper::CLASS)->reveal();
        $created = new \DateTimeImmutable;
        $updated = new \DateTimeImmutable;

        $contact = new Contact(
            'foobar',
            $account,
            $mail,
            $phone,
            true,
            'comment',
            'id',
            $created,
            $updated
        );

        $this->assertSame('foobar', $contact->getName());
        $this->assertSame($account, $contact->getAccountWrapper());
        $this->assertSame($mail, $contact->getMailWrapper());
        $this->assertSame($phone, $contact->getPhoneWrapper());
        $this->assertTrue($contact->isPayoutAllowed());
        $this->assertSame('comment', $contact->getComment());
        $this->assertSame('id', $contact->getId());
        $this->assertSame($created, $contact->getCreated());
        $this->assertSame($updated, $contact->getUpdated());
    }

    public function testGenerateId()
    {
        $contact = new Contact(
            '',
            $this->prophesize(AccountWrapper::CLASS)->reveal(),
            $this->prophesize(DataWrapper::CLASS)->reveal(),
            $this->prophesize(DataWrapper::CLASS)->reveal(),
            true
        );
        $this->assertInternalType('string', $contact->getId());
    }
}

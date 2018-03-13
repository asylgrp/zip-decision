<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\amount\Currency\SEK;

class ClaimArrayTest extends \PHPUnit\Framework\TestCase
{
    public function testCount()
    {
        $this->assertCount(0, new ClaimArray);
        $this->assertCount(1, new ClaimArray($this->createMock(Claim::CLASS)));
    }

    public function testAddClaim()
    {
        $container = new ClaimArray;
        $container->addClaim($this->createMock(Claim::CLASS));
        $this->assertCount(1, $container);
    }

    public function testGetFirstClaim()
    {
        $claim1 = $this->createMock(Claim::CLASS);
        $claim2 = $this->createMock(Claim::CLASS);

        $this->assertSame(
            $claim1,
            (new ClaimArray($claim1, $claim2))->getFirstClaim()
        );
    }

    public function testExceptionOnNoFirstClaim()
    {
        $this->expectException('\LogicException');
        (new ClaimArray)->getFirstClaim();
    }

    public function testIteration()
    {
        $this->assertNotEmpty(
            iterator_to_array(new ClaimArray($this->createMock(Claim::CLASS)))
        );
    }

    public function testGetId()
    {
        $contact = $this->prophesize(Contact::CLASS);
        $contact->getId()->willReturn('id');

        $date = new \DateTimeImmutable('@1');
        $amount = new SEK('2');

        $claim1 = $this->prophesize(Claim::CLASS);
        $claim1->getContact()->willReturn($contact);
        $claim1->getRequestedAmount()->willReturn($amount);
        $claim1->getApprovedAmount()->willReturn($amount);
        $claim1->getCreated()->willReturn($date);
        $claim1->getUpdated()->willReturn($date);

        $claim2 = $this->prophesize(Claim::CLASS);
        $claim2->getContact()->willReturn($contact);
        $claim2->getRequestedAmount()->willReturn($amount);
        $claim2->getApprovedAmount()->willReturn($amount);
        $claim2->getCreated()->willReturn($date);
        $claim2->getUpdated()->willReturn($date);

        $this->assertEquals(
            substr(md5('id2.002.0011id2.002.0011'), 0, 10),
            (new ClaimArray($claim1->reveal(), $claim2->reveal()))->getId()
        );
    }

    public function testSumRequested()
    {
        $claim1 = $this->prophesize(Claim::CLASS);
        $claim1->getRequestedAmount()->willReturn(new SEK('50'));

        $claim2 = $this->prophesize(Claim::CLASS);
        $claim2->getRequestedAmount()->willReturn(new SEK('50'));

        $this->assertEquals(
            new SEK('100'),
            (new ClaimArray($claim1->reveal(), $claim2->reveal()))->sumRequestedAmounts()
        );
    }

    public function testSumApproved()
    {
        $claim1 = $this->prophesize(Claim::CLASS);
        $claim1->getApprovedAmount()->willReturn(new SEK('50'));

        $claim2 = $this->prophesize(Claim::CLASS);
        $claim2->getApprovedAmount()->willReturn(new SEK('50'));

        $this->assertEquals(
            new SEK('100'),
            (new ClaimArray($claim1->reveal(), $claim2->reveal()))->sumApprovedAmounts()
        );
    }

    public function testSumNotApproved()
    {
        $claim1 = $this->prophesize(Claim::CLASS);
        $claim1->getNotApprovedAmount()->willReturn(new SEK('50'));

        $claim2 = $this->prophesize(Claim::CLASS);
        $claim2->getNotApprovedAmount()->willReturn(new SEK('50'));

        $this->assertEquals(
            new SEK('100'),
            (new ClaimArray($claim1->reveal(), $claim2->reveal()))->sumNotApprovedAmounts()
        );
    }
}

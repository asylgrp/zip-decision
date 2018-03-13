<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\amount\Currency\SEK;

class DecisionTest extends \PHPUnit\Framework\TestCase
{
    public function testGetValues()
    {
        $date = new \DateTimeImmutable;
        $id = 'foobar';
        $claims = $this->createMock(ClaimArray::CLASS);
        $fundsPre = new SEK('1');
        $fundsPost = new SEK('2');
        $ratio = new SEK('3');
        $guarantee = new SEK('4');
        $comment = 'comment';

        $decision = new Decision($date, $id, $claims, $fundsPre, $fundsPost, $ratio, $guarantee, $comment);

        $this->assertSame(
            $date,
            $decision->getCreated()
        );

        $this->assertSame(
            $date,
            $decision->getUpdated()
        );

        $this->assertSame(
            $id,
            $decision->getId()
        );

        $this->assertSame(
            $claims,
            $decision->getClaims()
        );

        $this->assertSame(
            $fundsPre,
            $decision->getFundsPre()
        );

        $this->assertSame(
            $fundsPost,
            $decision->getFundsPost()
        );

        $this->assertSame(
            $ratio,
            $decision->getRatio()
        );

        $this->assertSame(
            $guarantee,
            $decision->getGuarantee()
        );

        $this->assertSame(
            $comment,
            $decision->getComment()
        );
    }
}

<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision\Traits;

class DateableTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testAutoSetDates()
    {
        $dates = $this->getMockForTrait(DateableTrait::CLASS);
        $this->assertTrue(!!$dates->getCreated());
        $this->assertTrue(!!$dates->getUpdated());
    }

    public function testCompareDates()
    {
        $dates = $this->getMockForTrait(DateableTrait::CLASS);
        $this->assertFalse($dates->isOlderThan(new \DateTime('1990-01-01')));
    }
}

<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

class DataWrapperTest extends \PHPUnit\Framework\TestCase
{
    public function testGetters()
    {
        $date = new \DateTimeImmutable;
        $wrapper = new DataWrapper('value', 'comment', $date);

        $this->assertSame(
            'value',
            $wrapper->getValue()
        );

        $this->assertSame(
            'value',
            (string) $wrapper
        );

        $this->assertSame(
            'comment',
            $wrapper->getComment()
        );

        $this->assertSame(
            $date,
            $wrapper->getCreated()
        );

        $this->assertSame(
            $date,
            $wrapper->getUpdated()
        );
    }
}

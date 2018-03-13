<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\banking\AccountNumber;

class AccountWrapperTest extends \PHPUnit\Framework\TestCase
{
    public function testGetters()
    {
        $account = $this->createMock(AccountNumber::CLASS);
        $account->expects($this->once())->method('__toString')->will($this->returnValue('string'));

        $wrapper = new AccountWrapper($account);

        $this->assertSame(
            'string',
            $wrapper->getValue()
        );

        $this->assertSame(
            'string',
            (string)$wrapper
        );

        $this->assertSame(
            $account,
            $wrapper->getAccount()
        );
    }
}

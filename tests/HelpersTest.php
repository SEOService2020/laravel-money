<?php

namespace Cknow\Money;

use Money\Currencies\ISOCurrencies;
use Money\Currency;

class HelpersTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        Money::setCurrencies(new ISOCurrencies());
        Money::setLocale('en_US');
    }

    public function testCurrency()
    {
        static::assertEquals(money(25), new Money(25, new Currency('USD')));
        static::assertEquals(money(25, 'USD'), new Money(25, new Currency('USD')));
        static::assertEquals(money(25, 'EUR'), new Money(25, new Currency('EUR')));
    }

    public function testMoney()
    {
        static::assertEquals(currency('USD'), new Currency('USD'));
        static::assertEquals(currency('EUR'), new Currency('EUR'));
    }

    public function testMoneyParse()
    {
        static::assertEquals(money_parse('$1.00'), Money::USD(100));
        static::assertEquals(money_parse('$1.00', 'EUR'), Money::EUR(100));
        static::assertEquals(money_parse('$1.00', 'USD', 'en_US'), Money::USD(100));
        static::assertEquals(money_parse('$1.00', 'USD', 'en_US', Money::getCurrencies()), Money::USD(100));
    }

    public function testMoneyParseByBitcoin()
    {
        static::assertEquals(money_parse_by_bitcoin("\xC9\x831000.00"), Money::XBT(100000));
        static::assertEquals(money_parse_by_bitcoin("\xC9\x831000.00", null, 4), Money::XBT(10000000));
    }

    public function testMoneyParseByDecimal()
    {
        static::assertEquals(money_parse_by_decimal('5.00', 'EUR'), Money::EUR(500));
        static::assertEquals(money_parse_by_decimal('5.00', 'USD', null), Money::USD(500));
    }

    public function testMoneyParseIntl()
    {
        static::assertEquals(money_parse_by_intl('$1.00'), Money::USD(100));
        static::assertEquals(money_parse_by_intl('$1.00', 'EUR'), Money::EUR(100));
        static::assertEquals(money_parse_by_intl('$1.00', 'USD', 'en_US'), Money::USD(100));
        static::assertEquals(money_parse_by_intl('$1.00', 'USD', 'en_US', Money::getCurrencies()), Money::USD(100));
    }

    public function testMoneyParseIntlLocalizedDecimal()
    {
        static::assertEquals(money_parse_by_intl_localized_decimal('1.00', 'USD'), Money::USD(100));
        static::assertEquals(money_parse_by_intl_localized_decimal('1.00', 'EUR'), Money::EUR(100));
        static::assertEquals(money_parse_by_intl_localized_decimal('1.00', 'USD', 'en_US'), Money::USD(100));
        static::assertEquals(
            money_parse_by_intl_localized_decimal('1.00', 'USD', 'en_US', Money::getCurrencies()),
            Money::USD(100)
        );
    }
}

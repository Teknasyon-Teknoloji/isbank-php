<?php

namespace Teknasyon\Isbank\Tests;


use PHPUnit\Framework\TestCase;
use Teknasyon\Isbank\Helpers\CurrencyCode;


/**
 * Class CurrencyCodeTest
 * @package Teknasyon\Isbank\Tests
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class CurrencyCodeTest extends TestCase
{
    public function testAlphaToNumericConversion()
    {
        $this->assertEquals(949, (new CurrencyCode('TRY'))->toNumeric());

        $this->assertEquals(840, (new CurrencyCode('USD'))->toNumeric());

        $this->assertEquals(978, (new CurrencyCode('EUR'))->toNumeric());
    }

    public function testNumericToAlphaConversion()
    {
        $this->assertEquals('TRY', (new CurrencyCode('949'))->toAlpha());

        $this->assertEquals('USD', (new CurrencyCode(840))->toAlpha());

        $this->assertEquals('EUR', (new CurrencyCode('978'))->toAlpha());
    }

    public function testInvalidCodeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        new CurrencyCode('you shall not pass!');
    }
}
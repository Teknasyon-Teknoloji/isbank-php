<?php

namespace Teknasyon\Isbank\Tests;

use PHPUnit\Framework\TestCase;
use Teknasyon\Isbank\IsbankConfig;


/**
 * Class ConfigTest
 * @package Teknasyon\Isbank\Tests
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class ConfigTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        IsbankConfig::set('merchantId','123456');
        IsbankConfig::set('merchantPassword','000111');
        IsbankConfig::set('testEnvironment',true);
    }

    public function testCredentialsCanBeSetGlobally()
    {
        $this->assertEquals('123456',IsbankConfig::get('merchantId'));
        $this->assertEquals('000111',IsbankConfig::get('merchantPassword'));
    }

    public function testConfigDataCanBeSetAndDeleted()
    {
        IsbankConfig::set('teknasyon','rocks');
        $this->assertEquals('rocks',IsbankConfig::get('teknasyon'));
        IsbankConfig::delete('teknasyon');
        $this->assertEquals(null,IsbankConfig::get('teknasyon'));
    }

    public function testConfigDefaultParameterWorks()
    {
        $this->assertEquals('soIamReturned',IsbankConfig::get('iDoNotExist','soIamReturned'));
    }


}
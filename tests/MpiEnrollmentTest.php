<?php

namespace Teknasyon\Isbank\Tests;

use PHPUnit\Framework\TestCase;
use Teknasyon\Isbank\IsbankConfig;
use Teknasyon\Isbank\Services\MpiEnrollment\MpiEnrollmentParameters;
use Teknasyon\Isbank\Services\MpiEnrollment\MpiEnrollmentService;


/**
 * Class MpiEnrollmentTest
 * @package Teknasyon\Isbank\Tests
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class MpiEnrollmentTest extends TestCase
{
    /**
     * @var MpiEnrollmentService
     */
    protected $service;


    protected function setUp()
    {
        parent::setUp(); //
        IsbankConfig::set('testEnvironment', true);
        $this->service = new MpiEnrollmentService();
    }

    public function testGlobalTestEnvironmentConfigAppliesToTheService()
    {
        $this->assertTrue($this->service->isTestEnvironment());
    }
    
    public function testEndpointIsOfTheTestEnvironment()
    {
        $this->assertEquals(
            'https://sanalpos.innova.com.tr/ISBANK/MpiWeb/Enrollment.aspx',
            $this->service->getEndpoint()
        );
    }

    public function testParametersCanBeSet()
    {
        $pan = 123456789; // @todo rest of the params
        $this->service->params()
                      ->setPan($pan);

        $this->assertEquals($pan, $this->service->params()->getPan());
    }

    public function testParametersCanBeSetViaClosure()
    {

        $this->service->setParams(function (MpiEnrollmentParameters $params) {
            $params->setPan(123456789);
        });

        $this->assertEquals('123456789', $this->service->params()->getPan());
    }

    public function testAlphaCurrencyCodeGetsConvertedToNumericCode()
    {
        // TRY : 949
        $this->service->params()->setCurrency('TRY');
        $this->assertEquals(949, $this->service->params()->getCurrency());

        // USD : 840
        $this->service->params()->setCurrency('USD');
        $this->assertEquals(840, $this->service->params()->getCurrency());
    }

}
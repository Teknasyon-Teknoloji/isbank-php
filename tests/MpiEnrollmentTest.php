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


    protected function setUp(): void
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
        $pan = 1234567891234567; // @todo rest of the params
        $expiryDate = date('y') . date('m');
        $this->service->params()
            ->setPan($pan)
            ->setExpiryDate($expiryDate);

        $this->assertEquals($pan, $this->service->params()->getPan());
        $this->assertEquals($expiryDate, $this->service->params()->getExpiryDate());
    }

    public function testExpireDateAcceptsYYYYMMFormat()
    {
        $this->service->params()
            ->setExpiryDate(date('Y') . date('m'));

        $this->assertEquals(date('y') . date('m'), $this->service->params()->getExpiryDate());
    }

    public function testParametersCanBeSetViaClosure()
    {

        $this->service->setParams(function (MpiEnrollmentParameters $params) {
            $params->setPan(1234567891234567);
        });

        $this->assertEquals('1234567891234567', $this->service->params()->getPan());
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
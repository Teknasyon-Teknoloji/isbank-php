<?php

namespace Teknasyon\Isbank\Services\MpiEnrollment;

use Closure;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Teknasyon\Isbank\Services\AbstractService;


/**
 * Class EnrollmentService
 * @package Teknasyon\Isbank\Services\MpiEnrollment
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class MpiEnrollmentService extends AbstractService
{

    /**
     * @var MpiEnrollmentParameters
     */
    private $params;

    /**
     * EnrollmentService constructor.
     * @param MpiEnrollmentParameters $params
     */
    public function __construct(MpiEnrollmentParameters $params = null)
    {
        parent::__construct();
        $this->params = $params ?? new MpiEnrollmentParameters();
    }

    /**
     * @return MpiEnrollmentParameters
     */
    public function params()
    {
        return $this->params;
    }

    /**
     * @param MpiEnrollmentParameters|Closure $params
     */
    public function setParams($params)
    {
        if($params instanceof  MpiEnrollmentParameters) {
            $this->params = $params;
            return;
        } elseif ($params instanceof Closure) {
            $params($this->params);
            return;
        }

        throw new \InvalidArgumentException("Parameter should be type of MpiEnrollmentParameters or a closure");
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        if ($this->isTestEnvironment()) {
            return 'https://sanalpos.innova.com.tr/ISBANK/MpiWeb/Enrollment.aspx';
        }

        return 'https://mpi.vpos.isbank.com.tr/Enrollment.aspx';
    }


    /**
     * @return $this
     */
    public function buildRequest()
    {
        $this->request = new Request(
            'POST',
            $this->getEndpoint(),
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            http_build_query($this->params()->toArray(), null, '&')
        );

        return $this;
    }

    /**
     * @return bool|MpiEnrollmentResponse
     */
    public function getResponse()
    {
        if ($this->response instanceof ResponseInterface) {
            return new MpiEnrollmentResponse($this->response);
        }

        return false; // @idea fallback to a null object?
    }


}
<?php

namespace Teknasyon\Isbank\Services\VirtualPos;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Teknasyon\Isbank\Services\AbstractService;


/**
 * Class VirtualPosService
 * @package Teknasyon\Isbank\Services\VirtualPos
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class VirtualPosService extends AbstractService
{

    /**
     * @var VirtualPosParameters
     */
    private $params;

    /**
     * VirtualPosService constructor.
     * @param VirtualPosParameters $parameters
     */
    public function __construct(VirtualPosParameters $parameters = null)
    {
        parent::__construct();
        $this->params = $parameters ?? new VirtualPosParameters();
    }

    /**
     * @return VirtualPosParameters
     */
    public function params()
    {
        return $this->params;
    }

    /**
     * @param $params
     */
    public function setParams($params)
    {
        if($params instanceof  VirtualPosParameters) {
            $this->params = $params;
        } elseif ($params instanceof \Closure) {
            $params($this->params);
        }

        throw new \InvalidArgumentException("Parameter should be type of MpiEnrollmentParameters or a closure");
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        if ($this->isTestEnvironment()) {
            return 'http://sanalpos.innova.com.tr/ISBANK/VposWeb/v3/Vposreq.aspx';
        }

        return 'https://trx.vpos.isbank.com.tr/v3/Vposreq.aspx';
    }

    /**
     * @return VirtualPosService
     */
    public function buildRequest()
    {
        $this->request = new Request(
            'POST',
            $this->getEndpoint(),
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            http_build_query(['prmstr' => $this->params()->toXml()], null, '&')
        );

        return $this;
    }

    /**
     * @return bool|VirtualPosResponse
     */
    public function getResponse()
    {
        if ($this->response instanceof ResponseInterface) {
            return new VirtualPosResponse($this->response);
        }

        return false; // @idea fallback to a null object?
    }

}
<?php

namespace Teknasyon\Isbank\Services;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Teknasyon\Isbank\IsbankConfig;


/**
 * Class AbstractService
 * @package Teknasyon\Isbank
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
abstract class AbstractService
{

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var bool
     */
    protected $testEnvironment = false;


    /**
     * AbstractService constructor.
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient([
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::DEBUG => false,
            RequestOptions::VERIFY => __DIR__ . '/../../etc/ca-cert.pem'
        ]);

        if(IsbankConfig::get('testEnvironment') === true) {
            $this->setTestEnvironment(true);
        }
    }

    /**
     * @return mixed
     */
    abstract public function buildRequest();

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }


    /**
     * @return $this
     */
    public function makeRequest()
    {
        if ($this->request === null) {
            $this->buildRequest();
        }

        $this->response = $this->httpClient->send($this->request);
        return $this;
    }


    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isTestEnvironment(): bool
    {
        return $this->testEnvironment;
    }

    /**
     * @param bool $testEnvironment
     */
    public function setTestEnvironment(bool $testEnvironment)
    {
        $this->testEnvironment = $testEnvironment;
    }





}
<?php

namespace Teknasyon\Isbank\Services;

use Psr\Http\Message\ResponseInterface;


/**
 * Class AbstractResponse
 * @package Teknasyon\Isbank\Services
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
abstract class AbstractResponse
{

    /**
     * @var string
     */
    protected $xml;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * AbstractResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->xml = $response->getBody()->getContents();
        $this->parseXml();
    }

    abstract protected function parseXml();

    /**
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return $this->get($name);
    }

}
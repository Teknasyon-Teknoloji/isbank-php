<?php

namespace Teknasyon\Isbank\Services\VirtualPos;

use Psr\Http\Message\ResponseInterface;
use Teknasyon\Isbank\Services\AbstractResponse;


/**
 * Class VirtualPosResponse
 * @package Teknasyon\Isbank\Services\VirtualPos
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class VirtualPosResponse extends AbstractResponse
{

    protected function parseXml()
    {
        $xmlObj = new \SimpleXMLElement($this->getXml(),LIBXML_NOCDATA);
        $this->data = json_decode(json_encode($xmlObj), true);
    }

    public function isSuccessful() {
        return $this->get('ResultCode') === '0000';
    }

}
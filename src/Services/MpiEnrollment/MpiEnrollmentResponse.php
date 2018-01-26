<?php

namespace Teknasyon\Isbank\Services\MpiEnrollment;

use Teknasyon\Isbank\Services\AbstractResponse;


/**
 * Class EnrollmentResponse
 * @package Teknasyon\Isbank\Services\MpiEnrollment
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class MpiEnrollmentResponse extends AbstractResponse
{

    /**
     * @return void
     */
    protected function parseXml()
    {
        $dom = new \DOMDocument();

        try {
            $dom->loadXML($this->xml);
        } catch (\Exception $e) {
            return;
        }

        $statusNode = $dom->getElementsByTagName("Status")->item(0);
        if ($statusNode != null) {
            $this->data['Status'] = $statusNode->nodeValue;
        }

        $paReqNode = $dom->getElementsByTagName("PAReq")->item(0);
        if ($paReqNode != null) {
            $this->data['PAReq'] = $paReqNode->nodeValue;
        }

        $acsUrlNode = $dom->getElementsByTagName("ACSUrl")->item(0);
        if ($acsUrlNode != null) {
            $this->data['ACSUrl'] = $acsUrlNode->nodeValue;
        }

        $termUrlNode = $dom->getElementsByTagName("TermUrl")->item(0);
        if ($termUrlNode != null) {
            $this->data['TermUrl'] = $termUrlNode->nodeValue;
        }

        $mdNode = $dom->getElementsByTagName("MD")->item(0);
        if ($mdNode != null) {
            $this->data['MD'] = $mdNode->nodeValue;
        }

        $errorMessageNode = $dom->getElementsByTagName("ErrorMessage")->item(0);
        if ($errorMessageNode != null) {
            $this->data['ErrorMessage'] = $errorMessageNode->nodeValue;
        }

        $messageErrorCodeNode = $dom->getElementsByTagName("MessageErrorCode")->item(0);
        if ($messageErrorCodeNode != null) {
            $this->data['MessageErrorCode'] = $messageErrorCodeNode->nodeValue;
        }

    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Status' => $this->get('Status'),
            'PAReq' => $this->get('PAReq'),
            'ACSUrl' => $this->get('ACSUrl'),
            'TermUrl' => $this->get('TermUrl'),
            'MerchantData' => $this->get('MerchantData'),
            'ErrorMessage' => $this->get('ErrorMessage'),
            'MessageErrorCode' => $this->get('MessageErrorCode')
        ];
    }

}
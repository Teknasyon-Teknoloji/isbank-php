<?php

namespace Teknasyon\Isbank\Services\VirtualPos;

use Teknasyon\Isbank\Helpers\CurrencyCode;
use Teknasyon\Isbank\IsbankConfig;


/**
 * Class VirtualPosParameters
 * @package Teknasyon\Isbank\Services\VirtualPos
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class VirtualPosParameters
{
    protected $eci;
    protected $cavv;
    protected $mpiTransactionId;
    protected $merchantId;
    protected $merchantPassword;
    protected $transactionType;
    protected $transactionId;
    protected $currencyAmount;
    protected $currencyCode;
    protected $installmentCount;
    protected $pan;
    protected $cvv;
    protected $expiry;
    protected $clientIp;

    public function __construct()
    {
        $this->setTransactionType('Sale')
            ->setMerchantId(IsbankConfig::get('merchantId'))
            ->setMerchantPassword(IsbankConfig::get('merchantPassword'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    |
    */

    public function toXml()
    {
        $xml = '<VposRequest>'
            . '<Eci>' . $this->getEci() . '</Eci>'
            . '<Cavv>' . $this->getCavv() . '</Cavv>'
            . '<MpiTransactionId>' . $this->getMpiTransactionId() . '</MpiTransactionId>'
            . '<MerchantId>' . $this->getMerchantId() . '</MerchantId>'
            . '<Password>' . $this->getMerchantPassword() . '</Password>'
            . '<TransactionType>' . $this->getTransactionType() . '</TransactionType>'
            . '<TransactionId>' . $this->getTransactionId() . '</TransactionId>'
            . '<CurrencyAmount>' . $this->getCurrencyAmount() . '</CurrencyAmount>'
            . '<CurrencyCode>' . $this->getCurrencyCode() . '</CurrencyCode>';

        if (is_numeric($this->getInstallmentCount()) && $this->getInstallmentCount() > 0) {
            $xml .= '<InstallmentCount>' . $this->getInstallmentCount() . '</InstallmentCount>';
        }

        $xml .= '<Pan>' . $this->getPan() . '</Pan>'
            . '<Cvv>' . $this->getCvv() . '</Cvv>'
            . '<Expiry>' . $this->getExpiry() . '</Expiry>'
            . '<TransactionDeviceSource>0</TransactionDeviceSource>'
            . '<ClientIp>' . $this->getClientIp() . '</ClientIp>'
            . '</VposRequest>';

        return $xml;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters & Setters
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return mixed
     */
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * @param mixed $eci
     * @return VirtualPosParameters
     */
    public function setEci($eci)
    {
        $this->eci = $eci;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCavv()
    {
        return $this->cavv;
    }

    /**
     * @param mixed $cavv
     * @return VirtualPosParameters
     */
    public function setCavv($cavv)
    {
        $this->cavv = $cavv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMpiTransactionId()
    {
        return $this->mpiTransactionId;
    }

    /**
     * @param mixed $mpiTransactionId
     * @return VirtualPosParameters
     */
    public function setMpiTransactionId($mpiTransactionId)
    {
        $this->mpiTransactionId = $mpiTransactionId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     * @return VirtualPosParameters
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantPassword()
    {
        return $this->merchantPassword;
    }

    /**
     * @param mixed $merchantPassword
     * @return VirtualPosParameters
     */
    public function setMerchantPassword($merchantPassword)
    {
        $this->merchantPassword = $merchantPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param mixed $transactionType
     * @return VirtualPosParameters
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     * @return VirtualPosParameters
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrencyAmount()
    {
        return $this->currencyAmount;
    }

    /**
     * @param mixed $currencyAmount
     * @return VirtualPosParameters
     */
    public function setCurrencyAmount($currencyAmount)
    {
        $this->currencyAmount = $currencyAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param mixed $currencyCode
     * @return VirtualPosParameters
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = (new CurrencyCode($currencyCode))->toNumeric();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstallmentCount()
    {
        return $this->installmentCount;
    }

    /**
     * @param mixed $installmentCount
     */
    public function setInstallmentCount($installmentCount)
    {
        $this->installmentCount = $installmentCount;
    }


    /**
     * @return mixed
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param mixed $pan
     * @return VirtualPosParameters
     */
    public function setPan($pan)
    {
        $this->pan = $pan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * @param mixed $cvv
     * @return VirtualPosParameters
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * @param mixed $expiry
     * @return VirtualPosParameters
     */
    public function setExpiry($expiry)
    {
        // Convert YYMM to YYYYMM
        if (strlen($expiry) === 4) {
            $expiry = '20' . $expiry;
        }

        if (strlen($expiry) != 6
            || substr($expiry, 0, 4) < date('Y')
            || substr($expiry, 4, 2) > 31
            || substr($expiry, 4, 2) < 1) {
            throw new \InvalidArgumentException("Invalid expiry date provided as Isbank Virtual POS parameter.");
        }

        $this->expiry = $expiry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * @param mixed $clientIp
     * @return VirtualPosParameters
     */
    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;
        return $this;
    }


}
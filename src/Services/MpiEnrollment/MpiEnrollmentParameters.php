<?php

namespace Teknasyon\Isbank\Services\MpiEnrollment;

use Teknasyon\Isbank\Helpers\CurrencyCode;
use Teknasyon\Isbank\IsbankConfig;


/**
 * Class EnrollmentParameters
 * @package Teknasyon\Isbank\Services\Enrollment
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class MpiEnrollmentParameters
{
    protected $pan;
    protected $expiryDate;
    protected $purchaseAmount;
    protected $currency;
    protected $installmentCount;
    protected $brandName;
    protected $requestId;
    protected $successUrl;
    protected $failureUrl;
    protected $sessionInfo;
    protected $merchantId;
    protected $merchantPassword;


    public function __construct()
    {
        $this->setMerchantId(IsbankConfig::get('merchantId'))
            ->setMerchantPassword(IsbankConfig::get('merchantPassword'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    |
    */

    public function toArray()
    {
        $arr = [
            'Pan' => $this->getPan(),
            'ExpiryDate' => $this->getExpiryDate(),
            'PurchaseAmount' => number_format($this->getPurchaseAmount(), 2, '.', ''),
            'Currency' => $this->getCurrency(),
            'BrandName' => $this->getBrandName(),
            'SuccessUrl' => $this->getSuccessUrl(),
            'FailureUrl' => $this->getFailureUrl(),
            'SessionInfo' => $this->getSessionInfo(),
            'VerifyEnrollmentRequestId' => $this->getRequestId(),
            'MerchantId' => $this->getMerchantId(),
            'MerchantPassword' => $this->getMerchantPassword()
        ];


        if (!empty($this->getInstallmentCount())) {
            $arr['InstallmentCount'] = $this->getInstallmentCount();
        }

        return $arr;

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
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param mixed $pan
     * @return MpiEnrollmentParameters
     */
    public function setPan($pan)
    {
        if (strlen($pan) != 16 || !is_numeric($pan)) {
            throw new \InvalidArgumentException("Invalid Pan (card number)");
        }
        $this->pan = $pan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param mixed $expiryDate
     * @return MpiEnrollmentParameters
     */
    public function setExpiryDate($expiryDate)
    {
        if(strlen($expiryDate) === 6) {
            $expiryDate = substr($expiryDate,-4);
        }

        if(strlen($expiryDate) != 4
            || substr($expiryDate,0,2) < date('y')
            || substr($expiryDate,2,2) > 31
            || substr($expiryDate,2,2) < 1) {
            throw new \InvalidArgumentException("Expiry date must be in YYMM format, and cannot be a past date.");
        }

        $this->expiryDate = $expiryDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurchaseAmount()
    {
        return $this->purchaseAmount;
    }

    /**
     * @param mixed $purchaseAmount
     * @return MpiEnrollmentParameters
     */
    public function setPurchaseAmount($purchaseAmount)
    {
        $this->purchaseAmount = $purchaseAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return MpiEnrollmentParameters
     */
    public function setCurrency($currency)
    {

        $this->currency = (new CurrencyCode($currency))->toNumeric();
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
     * @return MpiEnrollmentParameters
     */
    public function setInstallmentCount($installmentCount)
    {
        $this->installmentCount = $installmentCount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBrandName()
    {
        return $this->brandName;
    }

    /**
     * @param mixed $brandName
     * @return MpiEnrollmentParameters
     */
    public function setBrandName($brandName)
    {
        if (strtolower($brandName) == 'visa') {
            $brandName = '100';
        } elseif (strtolower($brandName) == 'mastercard') {
            $brandName = '200';
        }

        if ($brandName != '100' && $brandName != '200') {
            throw new \InvalidArgumentException("Invalid BrandName given for MpiEnrollment parameter");
        }

        $this->brandName = $brandName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $requestId
     * @return MpiEnrollmentParameters
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->successUrl;
    }

    /**
     * @param mixed $successUrl
     * @return MpiEnrollmentParameters
     */
    public function setSuccessUrl($successUrl)
    {
        if(filter_var($successUrl, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("Invalid Success URL provided for Isbank MPI Enrollment service.");
        }
        $this->successUrl = $successUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFailureUrl()
    {
        return $this->failureUrl;
    }

    /**
     * @param mixed $failureUrl
     * @return MpiEnrollmentParameters
     */
    public function setFailureUrl($failureUrl)
    {
        if(filter_var($failureUrl, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("Invalid Failure URL provided for Isbank MPI Enrollment service.");
        }
        $this->failureUrl = $failureUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSessionInfo()
    {
        return $this->sessionInfo;
    }

    /**
     * @param mixed $sessionInfo
     * @return MpiEnrollmentParameters
     */
    public function setSessionInfo($sessionInfo)
    {
        $this->sessionInfo = $sessionInfo;
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
     * @return MpiEnrollmentParameters
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
     * @return MpiEnrollmentParameters
     */
    public function setMerchantPassword($merchantPassword)
    {
        $this->merchantPassword = $merchantPassword;
        return $this;
    }


}
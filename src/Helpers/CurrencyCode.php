<?php

namespace Teknasyon\Isbank\Helpers;


/**
 * Class CurrencyConverter
 * @package Teknasyon\Isbank\Helpers
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class CurrencyCode
{

    protected $alphaToNumeric = [
        'TRY' => 949,
        'USD' => 840,
        'EUR' => 978,
        'GBP' => 826
    ];

    protected $numericToAlpha = [
        949 => 'TRY',
        840 => 'USD',
        978 => 'EUR',
        826 => 'GBP'
    ];

    /**
     * @var mixed
     */
    private $code;

    /**
     * CurrencyCode constructor.
     * @param $code
     */
    public function __construct($code)
    {
        if(is_numeric($code) && array_key_exists($code,$this->numericToAlpha)) {
            $this->code = $code;
        } elseif(array_key_exists($code,$this->alphaToNumeric)) {
            $this->code = $this->alphaToNumeric[$code];
        } else {
            throw new \InvalidArgumentException("Currency code is not defined.");
        }
    }

    /**
     * @return mixed
     */
    public function toAlpha()
    {
        return $this->numericToAlpha[$this->code];
    }

    /**
     * @return mixed
     */
    public function toNumeric()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->toAlpha();
    }
}
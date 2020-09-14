<?php

namespace common\sources;

/**
 * Class RateDto
 * @package common\sources
 */
class RateDto
{
    /** @var string */
    public $source;

    /** @var string */
    public $currency;

    /** @var double */
    public $rate;

    /**
     * RateDto constructor.
     * @param $source
     * @param $currency
     * @param $rate
     */
    public function __construct($source, $currency, $rate)
    {
        $this->source = $source;
        $this->currency = $currency;
        $this->rate = $rate;
    }
}
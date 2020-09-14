<?php

namespace common\sources;

use yii\httpclient\Client;

/**
 * Interface Source
 * @package common\sources
 */
interface Source
{

    /**
     * Source constructor.
     * @param string $apiUrl
     * @param string $accessKey
     */
    public function __construct(string $apiUrl, string $accessKey);

    /**
     * @param string $source
     * @param array $currencies
     * @return RateDto[]
     */
    public function getCurrencies(string $source, array $currencies): array;
}
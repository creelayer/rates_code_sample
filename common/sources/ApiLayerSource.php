<?php

namespace common\sources;

use common\sources\exceptions\ImportException;
use yii\httpclient\Client;

/**
 * Class ApiLayerSource
 * @package common\sources
 */
class ApiLayerSource implements Source
{

    /** @var string */
    private $apiUrl;

    /** @var */
    private $accessKey;

    /** @var Client */
    private $client;

    /**
     * ApiLayerSource constructor.
     * @param string $apiUrl
     * @param string $accessKey
     */
    public function __construct(string $apiUrl, string $accessKey)
    {
        $this->client = new Client(['baseUrl' => $apiUrl]);
        $this->apiUrl = $apiUrl;
        $this->accessKey = $accessKey;
    }

    /**
     * @param string $source
     * @param array $currencies
     * @return array
     * @throws ImportException
     * @throws \yii\httpclient\Exception
     */
    public function getCurrencies(string $source, array $currencies): array
    {
        $currencies = implode(',', $currencies);

        $response = $this->client->get('api/live', [
            'access_key' => $this->accessKey,
            'currencies' => $currencies,
            'source' => $source,
            'format' => true
        ])->send();

        if (!$response->getIsOk()) {
            throw new ImportException("Import fail with code:" . $response->getStatusCode());
        }

        $data = $response->getData();

        if (!$data['success']) {
            throw new ImportException("Import fail. " . $data['error']['info']);
        }

        $rates = [];
        foreach ($data['quotes'] as $key => $rate) {
            $rates[] = new RateDto($source, substr($key, 3, 6), $rate);
        }

        return $rates;
    }


}
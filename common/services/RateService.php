<?php

namespace common\services;

use common\models\Rate;
use common\repositories\BaseRepository;
use common\repositories\RateRepository;
use common\sources\Source;
use frontend\models\RateFilter;

/**
 * Class RateService
 * @package common\services
 */
class RateService
{

    /** @var Source */
    private $source;

    /** @var BaseRepository */
    private $rateRepository;

    /** @var string[] */
    private $currencies;

    /**
     * RateService constructor.
     * @param Source $source
     * @param RateRepository $rateRepository
     */
    public function __construct(Source $source, RateRepository $rateRepository)
    {
        $this->source = $source;
        $this->rateRepository = $rateRepository;
    }

    /**
     * @return string[]
     */
    public function getCurrencies(): array
    {
        $this->currencies = $this->currencies ?? $this->rateRepository->getCurrenciesCodes();
        return $this->currencies;
    }

    /**
     * @param string[] $currencies
     */
    public function setCurrencies(array $currencies): void
    {
        $this->currencies = $currencies;
    }

    /**
     * @param string $source
     * @throws \yii\db\Exception
     */
    public function import(string $source = 'USD'): void
    {

        $models = array_map(function ($item) {
            return \Yii::createObject([
                'class' => Rate::class,
                'source' => $item->source,
                'currency' => $item->currency,
                'rate' => $item->rate
            ]);
        }, $this->source->getCurrencies($source, $this->currencies));

        $this->rateRepository->saveAll($models);
    }


    /**
     * @param string $code
     * @param string $source
     * @return Rate|null
     */
    public function findByCode(string $code, string $source = 'USD'): ?Rate
    {
        /** @var Rate $rate */
        $rate = $this->rateRepository->findOneByCode($code, $source)->one();
        return $rate;
    }

    /**
     * @param RateFilter $filter
     * @return array
     * @throws \Exception
     */
    public function findByFilter(RateFilter $filter): array
    {
        /** @var Rate[] $rates */
        $rates = $this->rateRepository->findByDate($filter->code, new \DateTime($filter->from), new \DateTime($filter->to))->all();
        return $rates;
    }


}
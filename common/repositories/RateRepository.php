<?php

namespace common\repositories;

use common\models\Rate;
use yii\db\ActiveQuery;

/**
 * Class RateRepository
 * @package common\models
 */
class RateRepository extends BaseRepository
{
    /**
     * @return mixed|string
     */
    public static function getClass(): string
    {
        return Rate::class;
    }

    /**
     * @param string $code
     * @param string $source
     * @return ActiveQuery
     */
    public function findOneByCode(string $code, string $source = 'USD'): ActiveQuery
    {
        return self::getClass()::find()
            ->andWhere([
                'source' => $source,
                'currency' => $code
            ]);
    }

    /**
     * @param string $code
     * @param \DateTime $from
     * @param \DateTime $to
     * @param string $source
     * @return ActiveQuery
     */
    public function findByDate(string $code, \DateTime $from, \DateTime $to, string $source = 'USD'): ActiveQuery
    {
        return self::getClass()::find()
            ->andWhere([
                'source' => $source,
                'currency' => $code
            ])
            ->andWhere(['between', 'created_at', $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s')])
            ->orderBy([
                'id' => SORT_DESC
            ]);
    }

    /**
     * @return array
     */
    public function getCurrenciesCodes(): array
    {
        return self::getClass()::find()->select('currency')->distinct()->createCommand()->queryColumn();
    }
}
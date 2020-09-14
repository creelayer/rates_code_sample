<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class RateFilterForm
 * @package frontend\models
 */
class RateFilter extends Model
{

    /** @var string */
    public $code;

    /** @var string */
    public $from;

    /** @var string */
    public $to;

    /** @var string[]  */
    public $codes = ['USD','UAH','RUB'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            ['code', 'in', 'range' => $this->codes],
            [['from', 'to'], 'date', 'format' => 'php:Y-m-d'],
            [['from'], 'default', 'value' => date('Y-m-d', time() - 7776000)],
            [['to'], 'default', 'value' => date('Y-m-d', time() + 86400)]
        ];
    }

}
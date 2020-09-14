<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_currency".
 *
 * @property string $uuid
 * @property string $source
 * @property string $currency
 * @property double $rate
 */
class Rate extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'currency', 'rate'], 'required'],
            [['rate'], 'number'],
            [['source', 'currency'], 'string', 'max' => 10],
            [['source', 'currency'], 'unique', 'targetAttribute' => ['source', 'currency']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'source' => 'Source',
            'currency' => 'Currency',
            'rate' => 'Rate',
        ];
    }

    public function fields()
    {
        return ['currency', 'rate', 'created_at'];
    }

}

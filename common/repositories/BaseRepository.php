<?php

namespace common\repositories;

use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractRepository
 * @package common\repositories
 */
abstract class BaseRepository implements Repository, PersistRepository
{

    /** @var mixed */
    protected $class;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->class = static::getClass();
    }

    /**
     * @return Connection
     */
    public function getDb(): Connection
    {
        return $this->class::getDb();
    }

    /**
     * @param ActiveRecord $entity
     * @return bool
     */
    public function save(ActiveRecord $entity): bool
    {
        return $entity->save(false);
    }

    /**
     * @param array $entities
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveAll(array $entities): bool
    {
        $model = new $this->class;
        $rows = ArrayHelper::getColumn($entities, 'attributes');

        array_walk($rows, function (&$item) {
            array_walk($item, function (&$row) {
                $row = $row ?? new Expression('default');
            });
        });

        return static::getDb()->createCommand()->batchInsert($this->class::tableName(), $model->attributes(), $rows)->execute();
    }
}
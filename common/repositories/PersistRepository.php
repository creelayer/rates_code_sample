<?php

namespace common\repositories;

use yii\db\ActiveRecord;

/**
 * Interface PersistRepository
 * @package common\repositories
 */
interface PersistRepository
{
    /**
     * @param ActiveRecord $entity
     * @return bool
     */
    public function save(ActiveRecord $entity): bool;

    /**
     * @param array $entities
     * @return mixed
     */
    public function saveAll(array $entities): bool;
}
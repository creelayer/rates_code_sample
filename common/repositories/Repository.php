<?php

namespace common\repositories;

use yii\db\Connection;

/**
 * Interface Repository
 * @package common\models
 */
interface Repository
{

    /**
     * @return string
     */
    public static function getClass(): string;

    /**
     * @return Connection
     */
    public function getDb(): Connection;
}
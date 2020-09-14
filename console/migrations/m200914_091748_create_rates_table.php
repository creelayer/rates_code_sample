<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rates}}`.
 */
class m200914_091748_create_rates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%rate}}', [
            'id' => $this->primaryKey(),
            'source' => $this->string(10)->notNull(),
            'currency' => $this->string(10)->notNull(),
            'rate' => $this->double()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('now()'),
        ]);
        // $this->addPrimaryKey('PK_rates', 'rate', 'id');
        $this->createIndex('rates_direction_idx', 'rate', ['currency', 'source']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rate}}');
    }
}

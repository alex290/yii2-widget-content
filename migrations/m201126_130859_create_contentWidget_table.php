<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contentWidget}}`.
 */
class m201126_130859_create_contentWidget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contentWidget}}', [
            'id' => $this->primaryKey(),
            'weight' => $this->integer(),
            'modelName' => $this->string(150)->notNull(),
            'itemId' => $this->integer(),
            'type' => $this->integer(),
            'data' => $this->json(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contentWidget}}');
    }
}

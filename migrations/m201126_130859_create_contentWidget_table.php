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
            'id' => $this->primaryKey()->unsigned(),
            'weight' => $this->integer()->unsigned()->notNull(),
            'modelName' => $this->string(150)->notNull(),
            'itemId' => $this->integer()->unsigned()->notNull(),
            'type' => $this->integer()->notNull(),
            'data' => $this->json()->notNull(),
        ]);

        $this->createIndex(
            'idx-contentWidget-weight',
            'contentWidget',
            'weight'
        );
    }

    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contentWidget}}');
    }
}



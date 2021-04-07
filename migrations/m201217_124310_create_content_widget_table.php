<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%content_widget}}`.
 */
class m201217_124310_create_content_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%content_widget}}', [
            'id' => $this->primaryKey()->unsigned(),
            'weight' => $this->integer()->unsigned()->notNull(),
            'model_name' => $this->string(150)->notNull(),
            'item_id' => $this->integer()->unsigned()->notNull(),
            'type' => $this->string(150)->notNull(),
            'data' => $this->json()->notNull(),
        ]);

        $this->createIndex(
            'idx-content_widget-weight',
            'content_widget',
            'weight'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%content_widget}}');
    }
}

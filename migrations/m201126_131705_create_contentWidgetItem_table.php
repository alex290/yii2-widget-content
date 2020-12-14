<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%content_widget_item}}`.
 */
class m201126_131705_create_content_widget_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%content_widget_item}}', [
            'id' => $this->primaryKey()->unsigned(),
            'contentId' => $this->integer()->unsigned()->notNull(),
            'data' => $this->json(),
        ]);

        $this->createIndex(
            'idx-content_widget_item-contentId',
            'content_widget_item',
            'contentId'
        );

        $this->addForeignKey(
            'fk-content_widget_item-contentId',
            'content_widget_item',
            'contentId',
            'contentWidget',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%content_widget_item}}');
    }
}




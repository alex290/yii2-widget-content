<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contentWidgetItem}}`.
 */
class m201126_131705_create_contentWidgetItem_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contentWidgetItem}}', [
            'id' => $this->primaryKey()->unsigned(),
            'contentId' => $this->integer()->unsigned()->notNull(),
            'data' => $this->json(),
        ]);

        $this->createIndex(
            'idx-contentWidgetItem-contentId',
            'contentWidgetItem',
            'contentId'
        );

        $this->addForeignKey(
            'fk-contentWidgetItem-contentId',
            'contentWidgetItem',
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
        $this->dropTable('{{%contentWidgetItem}}');
    }
}




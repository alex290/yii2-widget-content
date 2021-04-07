<?php

namespace alex290\widgetContent\models;

use Yii;

/**
 * This is the model class for table "content_widget_item".
 *
 * @property int $id
 * @property int $contentId
 * @property string|null $data
 *
 * @property ContentWidget $content
 */
class ContentWidgetItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_widget_item';
    }
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id','weight'], 'required'],
            [['content_id', 'weight'], 'integer'],
            [['data'], 'safe'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContentWidget::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'data' => 'Data',
            'weight' => 'Weight',
        ];
    }

    /**
     * Gets query for [[Content]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(ContentWidget::className(), ['id' => 'content_id']);
    }
}

<?php

namespace alex290\widgetContent\models;

use Yii;

/**
 * This is the model class for table "contentWidget".
 *
 * @property int $id
 * @property int $weight
 * @property string $modelName
 * @property int $itemId
 * @property int $type
 * @property string $data
 *
 * @property ContentWidgetItem[] $contentWidgetItems
 */
class ContentWidget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contentWidget';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weight', 'modelName', 'itemId', 'type', 'data'], 'required'],
            [['weight', 'itemId', 'type'], 'integer'],
            [['data'], 'safe'],
            [['modelName'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weight' => 'Weight',
            'modelName' => 'Model Name',
            'itemId' => 'Item ID',
            'type' => 'Type',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[ContentWidgetItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentWidgetItems()
    {
        return $this->hasMany(ContentWidgetItem::className(), ['contentId' => 'id']);
    }
}

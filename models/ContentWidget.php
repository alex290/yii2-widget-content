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

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public $imageFile;
    
    public function rules()
    {
        return [
            [['weight', 'modelName', 'itemId', 'type', 'data'], 'required'],
            [['weight', 'itemId', 'type'], 'integer'],
            [['data'], 'safe'],
            [['modelName'], 'string', 'max' => 150],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
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

    public function upload()
    {
        if ($this->validate()) {
            $path = 'upload/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path);
            $this->attachImage($path);
            unlink($path);
            return true;
        } else {
            return false;
        }
    }
}

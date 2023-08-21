<?php

namespace alex290\widgetContent\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "content_widget".
 *
 * @property int $id
 * @property int $weight
 * @property string $modelName
 * @property int $itemId
 * @property int $type
 * @property string $data
 *
 * @property contentWidgetItem[] $contentWidgetItems
 */
class ContentWidget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_widget';
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
     * Gets query for [[content_widgetItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getcontentWidgetItems()
    {
        return $this->hasMany(ContentWidgetItem::className(), ['contentId' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = 'upload/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path);
            if (exif_imagetype($path) != IMAGETYPE_WEBP) {
                $this->attachImage($path);
            }
            
            unlink($path);
            return true;
        } else {
            return false;
        }
    }
}

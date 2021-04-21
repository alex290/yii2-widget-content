<?php

namespace alex290\widgetContent\models;

use Yii;
use yii\helpers\FileHelper;
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
            [['weight', 'model_name', 'item_id', 'type', 'data'], 'required'],
            [['weight', 'item_id'], 'integer'],
            [['data'], 'safe'],
            [['model_name', 'type'], 'string', 'max' => 150],
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
            'model_name' => 'Model Name',
            'item_id' => 'Item ID',
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
        return $this->hasMany(ContentWidgetItem::className(), ['content_id' => 'id']);
    }

    public function upload()
    {
        $filePath = Yii::$app->getModule('widget-content')->path;
        if ($this->validate()) {
            $path = $filePath . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path);
            $this->attachImage($path);
            unlink($path);
            return true;
        } else {
            return false;
        }
    }






    public function saveFile($fileData)
    {
        $data = Json::decode($this->data);
        // debug($fileData);
        // die;
        $filePath = Yii::$app->getModule('widget-content')->path;
        $this->deleteFile();
        $dir = $filePath . '/files/ContentWidget/ContentWidget' . $this->id . '/';
        FileHelper::createDirectory($dir);
        $file = $fileData[0]->baseName . '.' . $fileData[0]->extension;
        $path = $dir . $file;
        $fileData[0]->saveAs($path);
        
        $newPath = $dir . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $fileData[0]->extension;
        rename($path, $newPath);
        $data[$fileData[1]] =['patch'=> $newPath, 'filename' => $file];

        // debug($data);
        // die;

        $this->data = Json::encode($data);
        $this->save();
    }

    public function deleteFile()
    {
        $filePath = Yii::$app->getModule('widget-content')->path;
        $dir = $filePath . '/files/ContentWidget/ContentWidget' . $this->id;
        FileHelper::removeDirectory($dir);
    }
}

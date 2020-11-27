<?php

namespace alex290\widgetContent\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;

class WidgetImage extends Model
{
    public $imageFile;
    public $weight;
    public $title;
    public $model;

    public function rules()
    {
        return [
            [['weight'], 'integer'],
            [['title'], 'string'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Изображение',
        ];
    }

    public function newModel($id, $modelName)
    {
        $model = new ContentWidget();
        $model->itemId = $id;
        $model->modelName = $modelName;
        $model->type = 2;
        $model->weight = ContentWidget::find()->andWhere(['itemId' => $id])->andWhere(['modelName' => $modelName])->count();
        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function openModel($id)
    {
        $model = ContentWidget::findOne($id);
        if ($model != null) {
            $data = Json::decode($model->data);
            if (array_key_exists('title', $data)) {
                $this->title = $data['title'];
            }
        } else {
            return null;
        }
        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function saveModel()
    {
        $filePath = Yii::$app->getModule('widget-content')->path;
        $model = $this->model;
        $model->data = Json::encode([
            'title' => $this->title,
        ]);

        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if ($model->save()) {
            if ($this->imageFile) {
                $path = $filePath.'/images' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                $model->removeImages();
                $this->imageFile->saveAs($path);
                $model->attachImage($path);
                unlink($path);
            }
        }
    }
}

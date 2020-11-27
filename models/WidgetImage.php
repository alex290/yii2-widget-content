<?php

namespace alex290\widgetContent\models;

use yii\base\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;

class WidgetImage extends Model
{
    public $imageFile;
    public $weight;
    public $model;

    public function rules()
    {
        return [
            [['weight'], 'integer'],
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
        if ($model == null) {
            $model = new ContentWidget();
            $model->articleId = $id;
            $model->type = 2;
            $model->weight = ContentWidget::find()->where(['articleId' => $id])->count();
        }
        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function saveModel()
    {
        $model = $this->model;

        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');


        $model->data = Json::encode([]);
        if ($model->save()) {
            if ($this->imageFile) {
                $path = 'upload/images' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                $model->removeImages();
                $this->imageFile->saveAs($path);
                $model->attachImage($path);
                unlink($path);
            }
        }
    }
}

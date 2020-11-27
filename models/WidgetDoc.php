<?php

namespace alex290\widgetContent\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class WidgetDoc extends Model
{
    public $file;
    public $fileName;
    public $title;
    public $path;
    public $weight;
    public $model;

    public function rules()
    {
        return [
            [['title', 'path', 'fileName'], 'string'],
            [['weight'], 'integer'],
            [['file'], 'file'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название документа',
            'file' => 'Файлы',
        ];
    }


    public function newModel($id, $modelName)
    {
        $model = new ContentWidget();
        $model->itemId = $id;
        $model->modelName = $modelName;
        $model->type = 3;
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
            $model->type = 3;
            $model->weight = ContentWidget::find()->where(['articleId' => $id])->count();
        } else {
            $data = Json::decode($model->data);
            if (array_key_exists('title', $data)) {
                $this->title = $data['title'];
            }
            if (array_key_exists('fileName', $data)) {
                $this->fileName = $data['fileName'];
            }
            if (array_key_exists('file', $data)) {
                $this->file = $data['file'];
            }
        }

        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function saveModel()
    {
        $model = $this->model;

        $this->file = UploadedFile::getInstance($this, 'file');
        $model->data = Json::encode([
            'title' => '',
            'file' => ''
        ]);
        if ($model->save()) {
            if ($this->file) {
                $this->deleteFile();
                $dir = 'upload/files/Article/Article' . $model->id . '/';
                FileHelper::createDirectory($dir);
                $file = $this->file->baseName . '.' . $this->file->extension;
                $path = $dir . $file;
                $this->file->saveAs($path);
                $newPath = $dir . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $this->file->extension;
                rename($path, $newPath);

                $title = $this->title;
                if ($title == null || $title == '') {
                    $title = $file;
                }

                $model->data = Json::encode([
                    'title' => $title,
                    'file' => $newPath,
                    'fileName' => $file,
                ]);
                $model->save(false);
            }
        }
    }

    public function deleteFile()
    {
        $model = $this->model;
        $dir = 'upload/files/Article/Article' . $model->id;
        FileHelper::removeDirectory($dir);
    }
}

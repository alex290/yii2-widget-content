<?php

namespace alex290\widgetContent\models;

use Codeception\Lib\Di;
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
        if ($model != null) {
            $data = Json::decode($model->data);
            if (!is_array($data)) {
                $data = Json::decode($data);
            }
            if (array_key_exists('title', $data)) {
                $this->title = $data['title'];
            }
            if (array_key_exists('fileName', $data)) {
                $this->fileName = $data['fileName'];
            }
            if (array_key_exists('file', $data)) {
                $this->file = $data['file'];
            }
        } else {
            return null;
        }
        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function saveModel()
    {
        $model = $this->model;

        $modelName = $model->modelName;

        $filePath = Yii::$app->getModule('widget-content')->path;

        $this->file = UploadedFile::getInstance($this, 'file');
        $model->data = Json::encode([
            'title' => '',
            'file' => ''
        ]);
        if ($model->save()) {
            if ($this->file) {
                $this->deleteFile();
                $dir = $filePath.'/files/'. $modelName.'/'. $modelName . $model->id . '/';
                FileHelper::createDirectory($dir);
                $file = $this->file->baseName . '.' . $this->file->extension;
                $path = $dir . $file;
                $this->file->saveAs($path);
                // debug($dir);
                // die;
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
                $model->save();
            }
        }
    }

    public function deleteFile()
    {
        $model = $this->model;
        $modelName = $model->modelName;
        $dir = 'upload/files/'. $modelName.'/'. $modelName . $model->id;
        FileHelper::removeDirectory($dir);
    }
}

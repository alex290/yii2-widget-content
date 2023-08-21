<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\ContentWidgetItem;
use alex290\widgetContent\Rules;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class AdminController extends Controller
{

    public function actionAdd()
    {
        $widget = Json::decode(Yii::$app->request->post('widget'));
        $modelName = Yii::$app->request->post('model');
        $keyType = Yii::$app->request->post('key');
        $url = Yii::$app->request->post('url');
        $id = Yii::$app->request->post('id');
        $feild = [];
        $formModel = null;
        if (array_key_exists('fields', $widget)) {
            foreach ($widget['fields'] as $key => $value) {
                $feild[] = $key;
            }
            $feild[] = 'model_name';
            $feild[] = 'item_id';
            $feild[] = 'type';
            $feild[] = 'widget';
            $feild[] = 'url';


            $formModel = Rules::add(new DynamicModel($feild), $widget['fields']);

            $formModel->addRule('model_name', 'string', ['max' => 255]);
            $formModel->addRule('item_id', 'integer');
            $formModel->addRule('type', 'string', ['max' => 255]);
            $formModel->addRule('widget', 'safe');
            $formModel->addRule('url', 'string', ['max' => 255]);

            $formModel->model_name = $modelName;
            $formModel->item_id = $id;
            $formModel->type = $keyType;
            $formModel->widget = Json::encode($widget['fields']);
            $formModel->url = $url;
        }
        $this->layout = false;
        // debug($url);

        $modelName = new ContentWidget();
        $modelName->model_name = $modelName;
        $modelName->item_id = $id;
        $modelName->type = $keyType;



        return $this->render('add', [
            'widget' => $widget,
            'formModel' => $formModel
        ]);
    }

    public function actionNew()
    {

        if ($data = Yii::$app->request->post()['DynamicModel']) {
            $widget = Json::decode($data['widget']);
            $uploadedFile = null;
            $uploadedDoc = [];
            foreach ($widget as $key => $value) {
                if ($value[0] == 'image') {
                    $uploadedFile = UploadedFile::getInstanceByName('DynamicModel[' . $key . ']');
                    unset($data[$key]);
                } elseif ($value[0] == 'file') {
                    $uploadedDoc = [UploadedFile::getInstanceByName('DynamicModel[' . $key . ']'), $key];
                }
            }
            $modelName = $data['model_name'];
            $itemId = $data['item_id'];
            $type = $data['type'];
            $url = $data['url'];
            unset($data['model_name']);
            unset($data['item_id']);
            unset($data['type']);
            unset($data['url']);
            unset($data['widget']);

            // $model = ContentWidget::find()->andWhere(['model_name' => $modelName])->andWhere(['type' => $type])->andWhere(['item_id' => $itemId])->one();

            $model = new ContentWidget();
            $model->model_name = $modelName;
            $model->type = $type;
            $model->item_id = $itemId;
            $model->weight = ContentWidget::find()->andWhere(['model_name' => $modelName])->andWhere(['item_id' => $itemId])->count();
            $model->data = Json::encode($data);
            if ($model->save()) {
                if ($uploadedFile) {
                    $filePath = Yii::$app->getModule('widget-content')->path;
                    $path = $filePath . '/' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                    $uploadedFile->saveAs($path);

                    if (exif_imagetype($path) != IMAGETYPE_WEBP) {
                        $model->attachImage($path);
                    }
                    
                    unlink($path);
                }
                if (!empty($uploadedDoc)) {
                    $model->saveFile($uploadedDoc);
                }
            }


            return $this->redirect($url);
        }


        return true;
    }

    public function actionUpdate()
    {

        $url = Yii::$app->request->post('url');
        $id = Yii::$app->request->post('id');
        $widget = Json::decode(Yii::$app->request->post('widget'));



        $img = false;

        foreach ($widget['fields'] as $key => $value) {
            if ($value[0] == 'image') {
                $img = true;
            }
        }

        $model = ContentWidget::findOne($id);

        $data = Json::decode($model->data);



        $feild = [];
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $feild[] = $key;
            }
        }
        if ($img == true) {
            $feild[] = 'image';
        }
        $feild[] = 'widget';
        $feild[] = 'url';
        $feild[] = 'id';
        $formModel = null;


        $formModel = Rules::update(new DynamicModel($feild), $data, $widget['fields']);

        if ($img == true) {
            $formModel->addRule('image', 'file', ['extensions' => 'png, jpg']);
        }

        // die;

        $formModel->addRule('widget', 'safe');
        $formModel->addRule('id', 'integer');
        $formModel->addRule('url', 'string', ['max' => 255]);

        $formModel->widget = Json::encode($widget);
        $formModel->url = $url;
        $formModel->id = $id;

        $this->layout = false;


        return $this->render('update', [
            'widget' => $widget,
            'formModel' => $formModel,
            'model' => $model
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $url = Yii::$app->request->get('url');

        $modelsItem = ContentWidgetItem::find()->where(['content_id' => $id])->all();
        if ($modelsItem != null) {
            foreach ($modelsItem as $key => $value) {
                $value->removeImages();
                $value->deleteFile();
                $value->delete();
            }
        }

        $model = ContentWidget::findOne($id);
        $modelName = $model->model_name;
        $itemId = $model->item_id;
        $model->removeImages();
        $model->deleteFile();
        $model->delete();

        $models = ContentWidget::find()->andWhere(['model_name' => $modelName])->andWhere(['item_id' => $itemId])->orderBy(['weight' => SORT_ASC])->all();
        if ($models != null) {
            foreach ($models as $key => $value) {
                $value->weight = $key;
                $value->save();
            }
        }

        return $this->redirect($url);
    }


    public function actionSave()
    {

        if ($data = Yii::$app->request->post()['DynamicModel']) {

            $model = ContentWidget::findOne($data['id']);
            unset($data['id']);
            $widget = Json::decode($data['widget']);
            unset($data['widget']);
            $url = $data['url'];
            unset($data['url']);


            $uploadedDoc = [];
            $uploadedFile = null;
            foreach ($widget['fields'] as $key => $value) {
                if ($value[0] == 'image') {
                    $uploadedFile = UploadedFile::getInstanceByName('DynamicModel[' . $key . ']');
                    unset($data[$key]);
                } elseif ($value[0] == 'file') {
                    $uploadedDoc = [UploadedFile::getInstanceByName('DynamicModel[' . $key . ']'), $key];
                }
            }

            $model->data = Json::encode($data);
            if ($model->save()) {
                if ($uploadedFile) {
                    $model->removeImages();
                    $filePath = Yii::$app->getModule('widget-content')->path;
                    $path = $filePath . '/' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                    $uploadedFile->saveAs($path);

                    if (exif_imagetype($path) != IMAGETYPE_WEBP) {
                        $model->attachImage($path);
                    }

                    
                    unlink($path);
                }
                if (!empty($uploadedDoc)) {
                    $model->saveFile($uploadedDoc);
                }
            }


            return $this->redirect($url);
        }


        return true;
    }
}

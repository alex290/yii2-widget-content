<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\ContentWidgetItem;
use alex290\widgetContent\Rules;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ItemController extends Controller
{
    public function actionAdd()
    {
        $widget = Json::decode(Yii::$app->request->post('widget'));
        $url = Yii::$app->request->post('url');
        $id = Yii::$app->request->post('id');

        // debug($widget);
        $feild = [];
        $formModel = null;

        $this->layout = false;

        if (array_key_exists('item', $widget)) {
            foreach ($widget['item'] as $key => $value) {
                $feild[] = $key;
            }
            $feild[] = 'content_id';
            $feild[] = 'widget';
            $feild[] = 'url';


            $formModel = Rules::add(new DynamicModel($feild), $widget['item']);

            $formModel->addRule('content_id', 'integer');
            $formModel->addRule('widget', 'safe');
            $formModel->addRule('url', 'string', ['max' => 255]);

            $formModel->content_id = $id;
            $formModel->widget = Json::encode($widget['item']);
            $formModel->url = $url;
        }
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
            foreach ($widget as $key => $value) {
                if ($value[0] == 'image') {
                    $uploadedFile = UploadedFile::getInstanceByName('DynamicModel[' . $key . ']');
                    unset($data[$key]);
                }
            }
            $contentId = $data['content_id'];
            $url = $data['url'];
            unset($data['content_id']);
            unset($data['url']);
            unset($data['widget']);

            // debug($uploadedFile);
            // die;

            $model = new ContentWidgetItem();
            $model->content_id = $contentId;
            $model->weight = ContentWidgetItem::find()->where(['content_id' => $contentId])->count();
            $model->data = Json::encode($data);
            if ($model->save()) {
                if ($uploadedFile) {
                    $filePath = Yii::$app->getModule('widget-content')->path;
                    $path = $filePath . '/' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                    $uploadedFile->saveAs($path);
                    $model->attachImage($path);
                    unlink($path);
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

        foreach ($widget['item'] as $key => $value) {
            if ($value[0] == 'image') {
                $img = true;
            }
        }

        $model = ContentWidgetItem::findOne($id);

        // debug($widget);
        // die;

        $data = Json::decode($model->data);



        $feild = [];
        $formModel = null;
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $feild[] = $key;
            }
            if ($img == true) {
                $feild[] = 'image';
            }

            $feild[] = 'widget';
            $feild[] = 'url';
            $feild[] = 'id';

            $formModel = Rules::update(new DynamicModel($feild), $data, $widget['item']);

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
        }
        $this->layout = false;

        return $this->render('update', [
            'widget' => $widget,
            'formModel' => $formModel,
            'model' => $model,
        ]);
    }

    public function actionSave()
    {

        if ($data = Yii::$app->request->post()['DynamicModel']) {

            $model = ContentWidgetItem::findOne($data['id']);

            
            unset($data['id']);
            $widget = Json::decode($data['widget']);
            unset($data['widget']);
            $url = $data['url'];
            unset($data['url']);



            $uploadedFile = null;
            foreach ($widget['item'] as $key => $value) {
                if ($value[0] == 'image') {
                    $uploadedFile = UploadedFile::getInstanceByName('DynamicModel[' . $key . ']');
                    unset($data[$key]);
                }
            }
            // debug($data);
            // die;

            $model->data = Json::encode($data);
            if ($model->save()) {
                if ($uploadedFile) {
                    $model->removeImages();
                    $filePath = Yii::$app->getModule('widget-content')->path;
                    $path = $filePath . '/' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                    $uploadedFile->saveAs($path);
                    $model->attachImage($path);
                    unlink($path);
                }
            }


            return $this->redirect($url);
        }
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $url = Yii::$app->request->get('url');

        $model = ContentWidgetItem::findOne($id);
        $contentId = $model->content_id;
        $model->removeImages();
        $model->delete();

        $models = ContentWidgetItem::find()->where(['content_id' => $contentId])->orderBy(['weight' => SORT_ASC])->all();
        if ($models != null) {
            foreach ($models as $key => $value) {
                $value->weight = $key;
                $value->save();
            }
        }

        return $this->redirect($url);
    }
}

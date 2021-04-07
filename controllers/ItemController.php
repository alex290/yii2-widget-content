<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\ContentWidgetItem;
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

            $formModel = new DynamicModel($feild);

            foreach ($widget['item'] as $key => $value) {
                if ($value[0] == 'image') {
                    $formModel->addRule($key, 'file', ['extensions' => 'png, jpg']);
                } else {
                    if (array_key_exists('max', $value)) $formModel->addRule($key, $value[0], ['max' => $value['max']]);
                    else $formModel->addRule($key, $value[0]);
                }
            }

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

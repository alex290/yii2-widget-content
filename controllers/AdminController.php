<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
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

            $formModel = new DynamicModel($feild);

            foreach ($widget['fields'] as $key => $value) {
                if ($value[0] == 'image') {
                    $formModel->addRule($key, 'file', ['extensions' => 'png, jpg']);
                } else {
                    if (array_key_exists('max', $value)) $formModel->addRule($key, $value[0], ['max' => $value['max']]);
                    else $formModel->addRule($key, $value[0]);
                }
            }
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
            foreach ($widget as $key => $value) {
                if ($value[0] == 'image') {
                    $uploadedFile = UploadedFile::getInstanceByName('DynamicModel[' . $key . ']');
                    unset($data[$key]);
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
                    // debug($path);
                    $model->attachImage($path);
                    unlink($path);
                }
            }


            // debug($widget);
            // debug($data);
            // debug($uploadedFile);

            return $this->redirect($url);
        }


        return true;
    }
}

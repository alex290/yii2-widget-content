<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\Json;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actionAdd()
    {
        $widget = Json::decode(Yii::$app->request->get('widget'));
        $modelName = Yii::$app->request->get('model');
        $key = Yii::$app->request->get('key');
        $id = Yii::$app->request->get('id');
        $feild = [];
        $formModel = null;
        if (array_key_exists('fields', $widget)) {
            foreach ($widget['fields'] as $key => $value) {
                $feild[] = $key;
            }
            $formModel = new DynamicModel($feild);

            foreach ($widget['fields'] as $key => $value) {
                if ($value[0] = 'image') {
                    $formModel->addRule($key, 'file', ['extensions' => 'png, jpg']);
                } else {
                    if (array_key_exists('max', $value)) $formModel->addRule($key, $value[0], ['max' => $value['max']]);
                    else $formModel->addRule($key, $value[0]);
                    
                }
            }
        }

        // debug($formModel);
        
        $modelName = new ContentWidget();
        $modelName->model_name = $modelName;
        $modelName->item_id = $id;
        $modelName->type = $key;

        
    }
    
}

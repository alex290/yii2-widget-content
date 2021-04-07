<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class DataController extends Controller
{

    public function actionSort()
    {
        $ids = Yii::$app->request->get('ids');
        foreach (Json::decode($ids) as $key => $id) {
            $model = ContentWidget::findOne($id);
            $model->weight = $key;
            $model->save();
        }
        return true;
    }
}

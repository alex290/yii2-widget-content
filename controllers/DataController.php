<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use yii\helpers\Json;
use yii\web\Controller;

class DataController extends Controller
{

    public function actionSortable($data)
    {
        foreach (Json::decode($data) as $key => $id) {
            $model = ContentWidget::findOne($id);
            $model->weight = $key;
            $model->save();
        }
        return true;
    }
}

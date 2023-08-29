<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use yii\helpers\Json;
use yii\web\Controller;

class DataController extends Controller
{

    public function actionSortable($data)
    {
        $dataFile = Json::decode($data);
        if (!is_array($dataFile)) {
            $dataFile = Json::decode($dataFile);
        }
        foreach ($dataFile as $key => $id) {
            $model = ContentWidget::findOne($id);
            $model->weight = $key;
            $model->save();
        }
        return true;
    }
}

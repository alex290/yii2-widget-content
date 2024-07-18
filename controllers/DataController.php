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

        $widget = [];
        // $posrArr = Json::decode($data['widget']);
        if (!is_array($ids)) {
            $widget = Json::decode($ids);
        } else {
            $widget = $ids;
        }

        foreach ($widget as $key => $id) {
            $model = ContentWidget::findOne($id);
            $model->weight = $key;
            $model->save();
        }
        return true;
    }
}

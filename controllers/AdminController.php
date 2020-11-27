<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\WidgetText;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actionAddText($id)
    {
        $modelName = Yii::$app->request->get('modelName');
        $id = Yii::$app->request->get('id');
        $patch = Yii::$app->request->get('patch');
        $url = Yii::$app->request->get('url');

        // debug($patch);
        // debug($modelName);
        // debug($id);

        $this->layout = false;
        $model = new WidgetText();
        $model->newModel($id, $modelName);
        debug($model);

        if ($model->load(Yii::$app->request->post())) {
            $model->saveModel();
            return $this->redirect($url);
        }

        return $this->render('add-text', [
            'model' => $model,
            'id' => $id,
            'url' => $url
        ]);
    }
}

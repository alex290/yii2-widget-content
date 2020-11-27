<?php

namespace alex290\widgetContent\controllers;

use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\WidgetDoc;
use alex290\widgetContent\models\WidgetImage;
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

        $this->layout = false;
        $model = new WidgetText();
        $model->newModel($id, $modelName);

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

    public function actionAddImage()
    {
        $modelName = Yii::$app->request->get('modelName');
        $id = Yii::$app->request->get('id');
        $patch = Yii::$app->request->get('patch');
        $url = Yii::$app->request->get('url');

        $this->layout = false;
        $model = new WidgetImage();
        $model->newModel($id, $modelName);

        if ($model->load(Yii::$app->request->post())) {
            $model->saveModel();
            return $this->redirect($url);
        }

        return $this->render('add-image', [
            'model' => $model,
            'id' => $id,
            'url' => $url
        ]);
    }

    public function actionAddDoc()
    {
        $modelName = Yii::$app->request->get('modelName');
        $id = Yii::$app->request->get('id');
        $patch = Yii::$app->request->get('patch');
        $url = Yii::$app->request->get('url');

        $this->layout = false;
        $model = new WidgetDoc();
        $model->newModel($id, $modelName);

        if ($model->load(Yii::$app->request->post())) {
            $model->saveModel();
            return $this->redirect($url);
        }

        return $this->render('add-doc', [
            'model' => $model,
            'id' => $id,
            'url' => $url
        ]);
    }

    public function actionDeleteWidget()
    {
        $id = Yii::$app->request->get('id');
        $url = Yii::$app->request->get('url');
        $model = ContentWidget::findOne($id);
        if ($model->type == 3) {
            $articleDoc = new WidgetDoc();
            $articleDoc->openModel($model->id);
            $articleDoc->deleteFile();
        }
        $model->removeImages();
        $model->delete();

        return $this->redirect($url);
    }
}

<?php

namespace alex290\widgetContent\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\helpers\Json;
use yii\web\Controller;

class ItemController extends Controller
{
    public function actionAdd()
    {
        $widget = Json::decode(Yii::$app->request->get('widget'));
        $url = Yii::$app->request->get('url');
        $id = Yii::$app->request->get('id');

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
}

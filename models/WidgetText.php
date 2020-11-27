<?php

namespace alex290\widgetContent\models;

use yii\base\Model;
use yii\helpers\Json;

class WidgetText extends Model
{
    public $text;
    public $weight;
    public $model;

    public function rules()
    {
        return [
            [['text'], 'string'],
            [['weight'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Текст',
        ];
    }

    public function newModel($id, $modelName)
    {
        $model = new ContentWidget();
        $model->itemId = $id;
        $model->modelName = $modelName;
        $model->type = 1;
        $model->weight = ContentWidget::find()->andWhere(['itemId' => $id])->andWhere(['modelName' => $modelName])->count();
        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function openModel($id)
    {
        $model = ContentWidget::findOne($id);
        if ($model == null) {
            $model = new ContentWidget();
            $model->articleId = $id;
            $model->type = 1;
            $model->weight = ContentWidget::find()->where(['articleId' => $id])->count();
        } else {
            $data = Json::decode($model->data);
            if (array_key_exists('text', $data)) {
                $this->text = $data['text'];
            }
        }
        $this->weight = $model->weight;
        $this->model = $model;
    }

    public function saveModel()
    {
        $model = $this->model;

        $model->data = Json::encode([
            'text' => $this->text,
        ]);
        $model->save();
    }
}

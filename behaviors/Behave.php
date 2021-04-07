<?php



namespace alex290\widgetContent\behaviors;

// use alex290\yii2images\models\Image;

use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\ContentWidgetItem;
use alex290\widgetContent\models\WidgetDoc;
use Yii;
use yii\base\Behavior;
use yii\helpers\Json;
use yii\helpers\Url;

class Behave extends Behavior
{

    public function getInfo()
    {
        $itemId = $this->owner->primaryKey;
        $modelName = $this->getModule()->getShortClass($this->owner);
        return 'id - ' . $itemId . '. model name - ' . $modelName;
    }

    public function getWidget($widget = null)
    {
        $model = $this->owner;
        $modelNamePath = $model->className();
        $data = explode("\\", $modelNamePath);
        $modelName = $data[(count($data) - 1)];
        $path = str_replace($modelName, '', $modelNamePath);
        $url = Url::to();

        // debug($widget);

        $html = $this->adminHtml($model->id, $modelName, $path, $url, $widget);
        return $html;
    }

    public function getContent()
    {
        $model = $this->owner;
        $modelNamePath = $model->className();
        $data = explode("\\", $modelNamePath);
        $modelName = $data[(count($data) - 1)];

        $content = [];

        $modelWidget = ContentWidget::find()->andWhere(['item_id' => $model->id])->andWhere(['model_name' => $modelName])->orderBy(['weight' => SORT_ASC])->all();
        if ($modelWidget != null) {
            foreach ($modelWidget as $key => $value) {
                    $modelWidgetItem = ContentWidgetItem::find()->where(['content_id' => $value->id])->orderBy(['weight' => SORT_ASC])->all();
                    $content[] = [
                        'model' => $value,
                        'item' => $modelWidgetItem,
                    ];
            }
        }

        return $content;
    }

    public function removeWidgetAll()
    {
        $model = $this->owner;
        $modelNamePath = $model->className();
        $data = explode("\\", $modelNamePath);
        $modelName = $data[(count($data) - 1)];

        $modelWidgets = ContentWidget::find()->andWhere(['itemId' => $model->id])->andWhere(['modelName' => $modelName])->orderBy(['weight' => SORT_ASC])->all();

        if ($modelWidgets != null) {
            foreach ($modelWidgets as $key => $value) {
                $modelsItem = ContentWidgetItem::find()->where(['content_id' => $value->id])->all();
                if ($modelsItem != null) {
                    foreach ($modelsItem as $keyItem => $valueItem) {
                        $valueItem->removeImages();
                        $valueItem->deleteFile();
                        $valueItem->delete();
                    }
                }
        
                $value->removeImages();
                $value->deleteFile();
                $value->delete();
    
            }
        }
    }

    public function removeWidget($id)
    {
        $modelsItem = ContentWidgetItem::find()->where(['content_id' => $id])->all();
        if ($modelsItem != null) {
            foreach ($modelsItem as $key => $value) {
                $value->removeImages();
                $value->deleteFile();
                $value->delete();
            }
        }

        $model = ContentWidget::findOne($id);
        $modelName = $model->model_name;
        $itemId = $model->item_id;
        $model->removeImages();
        $model->deleteFile();
        $model->delete();

        $models = ContentWidget::find()->andWhere(['model_name' => $modelName])->andWhere(['item_id' => $itemId])->orderBy(['weight' => SORT_ASC])->all();
        if ($models != null) {
            foreach ($models as $key => $value) {
                $value->weight = $key;
                $value->save();
            }
        }
    }

    protected function adminHtml($itemId, $modelName, $subdir, $url, $widget)
    {
        ob_start();
        include __DIR__ . '/../tpl/admin-html.php';
        return ob_get_clean();
    }
}

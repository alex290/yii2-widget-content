<?php



namespace alex290\widgetContent\behaviors;

// use alex290\yii2images\models\Image;

use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\WidgetDoc;
use Yii;
use yii\base\Behavior;
use yii\helpers\Url;

class Behave extends Behavior
{

    public function getInfo()
    {
        $itemId = $this->owner->primaryKey;
        $modelName = $this->getModule()->getShortClass($this->owner);
        return 'id - ' . $itemId . '. model name - ' . $modelName;
    }

    public function getWidget()
    {
        $model = $this->owner;
        $modelNamePath = $model->className();
        $data = explode("\\", $modelNamePath);
        $modelName = $data[(count($data) - 1)];
        $path = str_replace($modelName, '', $modelNamePath);
        $url = Url::to();

        // debug($imagesPath);

        $html = $this->adminHtml($model->id, $modelName, $path, $url);
        return $html;
    }

    public function getContent()
    {
        $model = $this->owner;
        $modelNamePath = $model->className();
        $data = explode("\\", $modelNamePath);
        $modelName = $data[(count($data) - 1)];

        $modelWidget = ContentWidget::find()->andWhere(['itemId' => $model->id])->andWhere(['modelName' => $modelName])->orderBy(['weight' => SORT_ASC])->all();

        return $modelWidget;
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
                if ($value->type == 3) {
                    $articleDoc = new WidgetDoc();
                    $articleDoc->openModel($value->id);
                    $articleDoc->deleteFile();
                }
                $value->removeImages();
                $value->delete();
            }
        }
    }

    public function removeWidget($id)
    {
        $modelWidget = ContentWidget::findOne($id);
        if ($modelWidget != null) {

            if ($modelWidget->type == 3) {
                $articleDoc = new WidgetDoc();
                $articleDoc->openModel($modelWidget->id);
                $articleDoc->deleteFile();
            }
            $modelWidget->removeImages();
            $modelWidget->delete();
        }
    }

    protected function adminHtml($itemId, $modelName, $subdir, $url)
    {
        ob_start();
        include __DIR__ . '/../tpl/admin-html.php';
        return ob_get_clean();
    }
}

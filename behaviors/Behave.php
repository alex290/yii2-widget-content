<?php



namespace alex290\widgetContent\behaviors;

// use alex290\yii2images\models\Image;

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
        $itemId = $this->owner->primaryKey;
        
        $model = $this->owner;
        $modelNamePath = $model->className();
        $data = explode("\\", $modelNamePath);
        $modelName = $data[(count($data) - 1)];
        $path = str_replace($modelName, '', $modelNamePath);
        $url = Url::to();
        // debug($url);

        $html = $this->adminHtml($model->id, $modelName, $path, $url);
        return $html;
    }

    protected function adminHtml($itemId, $modelName, $subdir, $url){
        ob_start();
        include __DIR__ . '/../tpl/admin-html.php';
        return ob_get_clean();
    }
}

<?php



namespace alex290\widgetContent\behaviors;

// use alex290\yii2images\models\Image;

use yii\base\Behavior;
use \alex290\yii2images\ModuleTrait;

class Behave extends Behavior
{
    use ModuleTrait;

    public function getInfo()
    {
        $itemId = $this->owner->primaryKey;
        $modelName = $this->getModule()->getShortClass($this->owner);
        return 'id - ' . $itemId . '. model name - ' . $modelName;
    }
}

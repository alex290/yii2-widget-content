<?php

use alex290\widgetContent\assets\ContWidgetAsset;
use alex290\widgetContent\models\ContentWidget;
use yii\helpers\Json;

ContWidgetAsset::register(Yii::$app->view);

$models = ContentWidget::find()->andWhere(['modelName' => $modelName])->andWhere(['itemId' => $itemId])->orderBy(['weight' => SORT_ASC])->all();
$data = Json::encode([
    'patch' => $subdir,
    'model' => $modelName,
    'id' => $itemId,
    'url' => $url,
]);

?>


<?php if ($models != null) : ?>
    <?php foreach ($models as $key => $widget) : ?>
        <div class="card" data-id=<?= $widget->id ?>>
            <?php if ($widget->type == 1) : ?>
                <?= $this->render('widget/text', [
                    'widget' => $widget,
                ]) ?>
            <?php elseif ($widget->type == 2) : ?>
                <?= $this->render('widget/image', [
                    'widget' => $widget,
                ]) ?>
            <?php elseif ($widget->type == 3) : ?>
                <?= $this->render('widget/doc', [
                    'widget' => $widget,
                ]) ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
<div class="float-left w-100 newContent"></div>
<div class="float-left w-100 d-flex justify-content-center mt-5 wdgetAddBtn">
    <button type="button" class="btn btn-outline-dark" data-toggle="collapse" data-target="#collapseWidgetContent" aria-expanded="false" aria-controls="collapseWidgetContent"><i class="fas fa-plus"></i></button>
</div>

<div class="collapse" id="collapseWidgetContent">
    <div class="card card-body">
        <div class="d-flex flex-wrap">
            <button type="button" class="btn btn-outline-dark btn-lg mr-3 ml-3 mb-4" onclick='addWidgetText(<?= $data ?>)'>Текст</button>
            <button type="button" class="btn btn-outline-dark btn-lg mr-3 ml-3 mb-4" onclick='addWidgetImage(<?= $data ?>)'>Изображение</button>
            <button type="button" class="btn btn-outline-dark btn-lg mr-3 ml-3 mb-4" onclick='addWidgetDoc(<?= $data ?>)'>Файл(Документ)</button>
        </div>
    </div>
</div>
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
<div class="sortableWidgetContent">
    <?php foreach ($models as $key => $widget) : ?>
        <div class="card sortableWidgetContentItem" data-id=<?= $widget->id ?>>
            <?php if ($widget->type == 1) : ?>
                <?= Yii::$app->view->render('@alex290/widgetContent/tpl/widget/text', [
                    'widget' => $widget,
                ]) ?>

            <?php elseif ($widget->type == 2) : ?>
                <?= Yii::$app->view->render('@alex290/widgetContent/tpl/widget/image', [
                    'widget' => $widget,
                ]) ?>
            <?php elseif ($widget->type == 3) : ?>
                <?= Yii::$app->view->render('@alex290/widgetContent/tpl/widget/doc', [
                    'widget' => $widget,
                ]) ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
    </div>
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
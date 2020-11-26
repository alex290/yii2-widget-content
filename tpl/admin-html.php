<?php

use alex290\widgetContent\assets\ContWidgetAsset;
use alex290\widgetContent\models\ContentWidget;
use yii\helpers\Json;

ContWidgetAsset::register(Yii::$app->view);

$models = ContentWidget::find()->andWhere(['modelName' => $modelName])->andWhere(['itemId' => $itemId])->orderBy(['weight' => SORT_ASC])->all();
$data = [$modelName,$itemId];
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
    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#addWidget"><i class="fas fa-plus"></i></button>
</div>

<!-- Modal -->
<div class="modal fade" id="addWidget" tabindex="-1" role="dialog" aria-labelledby="addWidgetLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWidgetLabel">Добавить содержимое</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex flex-wrap">
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 ml-3 mb-4" onclick='addWidgetText("<?= Json::encode($data) ?>")'>Текст</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 ml-3 mb-4" onclick='addWidgetImage("<?= Json::encode($data) ?>")'>Изображение</button>
                <button type="button" class="btn btn-outline-dark btn-lg mr-3 ml-3 mb-4" onclick='addWidgetDoc("<?= Json::encode($data) ?>")'>Файл(Документ)</button>
            </div>
        </div>
    </div>
</div>
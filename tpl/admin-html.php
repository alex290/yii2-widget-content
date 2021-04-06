<?php

use alex290\widgetContent\assets\ContWidgetAsset;
use alex290\widgetContent\models\ContentWidget;
use yii\helpers\Json;
use yii\helpers\Url;

ContWidgetAsset::register(Yii::$app->view);

$models = ContentWidget::find()->andWhere(['model_name' => $modelName])->andWhere(['item_id' => $itemId])->orderBy(['weight' => SORT_ASC])->all();
// debug($widget);

?>

<div class="row">
    <div class="col-12 d-flex align-items-center flex-column">
        <div class="w-100 get_cont_add_widget"></div>
        <div class="w-100 d-flex align-items-center flex-column showRemove">
            <button class="btn_add_pages mb-5" onclick="showWodgetGrantPage()"><i class="fas fa-plus"></i></button>
            <div class="widget_add_cont w-100">
                <div class="card card-body w-100">
                    <div class="carusel_widget">
                        <?php if (!empty($widget)) : ?>
                            <?php foreach ($widget as $key => $valueWidget) : ?>
                                <div class="pl-3 pr-3">
                                    <div class="card">
                                        <div class="card-img-widg">
                                            <div class="img" alt="..." style="background-image: url(<?= $valueWidget['preview'] ?>);"></div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $valueWidget['name'] ?></h5>
                                            <button href="#" class="btn btn-primary" onclick='pagesAddContWidget(<?= Json::encode([$modelName, $itemId, $key, $valueWidget, Url::to()]) ?>)'>Добавить</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
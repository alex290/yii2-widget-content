<?php

use alex290\widgetContent\assets\ContWidgetAsset;
use alex290\widgetContent\models\ContentWidget;
use alex290\widgetContent\models\WidgetDoc;
use yii\helpers\Json;

ContWidgetAsset::register(Yii::$app->view);

$models = ContentWidget::find()->andWhere(['model_name' => $modelName])->andWhere(['item_id' => $itemId])->orderBy(['weight' => SORT_ASC])->all();
$data = Json::encode([
    'patch' => $subdir,
    'model' => $modelName,
    'id' => $itemId,
    'url' => $url,
]);



?>

<div class="row">
    <div class="col-12 d-flex align-items-center flex-column">
        <div class="w-100 get_cont_add_widget"></div>
        <div class="w-100 d-flex align-items-center flex-column showRemove">
            <button class="btn_add_pages mb-5" onclick="showWodgetGrantPage()"><i class="fas fa-plus"></i></button>
            <div class="widget_add_cont w-100">
                <div class="card card-body w-100">
                    <div class="carusel_widget">
                        <div class="pl-3 pr-3">
                            <div class="card">
                                <div class="card-img-widg">
                                    <div class="img" alt="..." style="background-image: url(/web/images/pages/widget/header.png);"></div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Шапка</h5>
                                    <button href="#" class="btn btn-primary" onclick="pagesAddContWidget()">Добавить</button>
                                </div>
                            </div>
                        </div>

                        <div class="pl-3 pr-3">
                            <div class="card">
                                <div class="card-img-widg">
                                    <div class="img" alt="..." style="background-image: url(/web/images/pages/widget/textImage.png);"></div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Текст с картинкой</h5>
                                    <button href="#" class="btn btn-primary" onclick="pagesAddContWidget()">Добавить</button>
                                </div>
                            </div>
                        </div>
                        <div class="pl-3 pr-3">
                            <div class="card">
                                <div class="card-img-widg">
                                    <div class="img" alt="..." style="background-image: url(/web/images/pages/widget/textImageCard.png);"></div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Карточки - текст с картинкой</h5>
                                    <button href="#" class="btn btn-primary" onclick="pagesAddContWidget()">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
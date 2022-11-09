<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$data = Json::decode($widget->data);
$url = Url::to();
$updateWidgetText = Json::encode([
    'id' => $widget->id,
    'url' => $url,
]);

?>
<div class="card-header d-flex justify-content-between haderWidgetUpr<?= $widget->id ?>">
    <div class="float-left">
        <i class="fas fa-grip-lines" style="cursor: pointer;"></i>
        <button class="btn btn-primary ml-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidCont<?= $widget->id ?>" aria-expanded="false" aria-controls="collapseWidCont<?= $widget->id ?>"><i class="fas fa-angle-double-down"></i></button>
    </div>
    <h2 class="font-weight-light">Изображение</h2>
    <div class="float-left d-flex justify-content-end">
        <button type="button" class="btn btn-outline-dark btn-sm" onclick='updateWidgetImage(<?= $updateWidgetText ?>)'><i class="fas fa-pencil-alt"></i></button>
        <?= Html::a('<i class="far fa-trash-alt"></i>', ['/widget-content/admin/delete-widget', 'id' => $widget->id, 'url' => $url], ['class' => 'btn btn-outline-dark btn-sm', 'data-confirm' => "Вы уверены, что хотите удалить этот элемент?", 'data-method' => 'post']) ?>
    </div>
</div>
<div class="card-body bodyWidgetUpr<?= $widget->id ?> bodyWidget">
    <div class="collapse" id="collapseWidCont<?= $widget->id ?>">
        <div class="card card-body">
            <img src="/web/<?= $widget->getImage()->getPath() ?>" style="max-width: 100%;" alt="">
            <h6><?= $data['title'] ?></h6>
        </div>
    </div>

</div>
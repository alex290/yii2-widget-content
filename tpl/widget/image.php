<?php

use yii\helpers\Html;

?>
<div class="card-header d-flex justify-content-between haderWidgetUpr<?= $widget->id ?>">
    <div class="float-left"><i class="fas fa-grip-lines"></i></div>
    <div class="float-left d-flex justify-content-end">
        <button type="button" class="btn btn-outline-dark btn-sm" onclick="updateArticleImage(<?= $widget->id ?>)"><i class="fas fa-pencil-alt"></i></button>
        <?= Html::a('<i class="far fa-trash-alt"></i>', ['/admin/article/delete-widget', 'id' => $widget->id], ['class' => 'btn btn-outline-dark btn-sm', 'data-confirm' => "Вы уверены, что хотите удалить этот элемент?", 'data-method'=>'post']) ?>
    </div>
</div>
<div class="card-body bodyWidgetUpr<?= $widget->id ?> bodyWidget">
    <img src="/web/<?= $widget->getImage()->getPath() ?>" alt="">
</div>
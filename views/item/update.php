<?php

use alex290\widgetContent\models\ContentWidgetItem;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


// debug($widget);


?>
<div class="card">
    <div class="card-header position-relative">
        <h5>Изменить </h5>
        <button class="btn_setting_pages_close" onclick="widgetClose()"><i class="far fa-times-circle"></i></button>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'action' => "/widget-content/item/save",
        ]) ?>
        <?= $form->field($formModel, 'id')->hiddenInput()->label(false) ?>
        <?php foreach ($widget['item'] as $key => $value) : ?>
            <div class="mt-3">
                <?php if ($value[0] == 'image') : ?>
                    <?= $form->field($formModel, 'image')->fileInput(['class' => 'image-fileinput', 'data-image' => $model->getImage()->getPath()])->label((array_key_exists('label', $value)) ?  $value['label'] : $key) ?>
                <?php elseif ($value[0] == 'string' && array_key_exists('max', $value)) : ?>
                    <?= $form->field($formModel, $key)->textInput()->label((array_key_exists('label', $value)) ?  $value['label'] : $key) ?>
                <?php elseif ($value[0] == 'select') : ?>
                    <?= $form->field($formModel, $key)->dropDownList($widget['item'][$key][1])->label((array_key_exists('label', $value)) ?  $value['label'] : $key) ?>
                <?php elseif ($value[0] == 'integer') : ?>
                    <?= $form->field($formModel, $key)->textInput(['type' => 'number'])->label((array_key_exists('label', $value)) ?  $value['label'] : $key) ?>
                <?php elseif ($value[0] == 'file') : ?>
                    <?= $form->field($formModel, $key)->fileInput()->label((array_key_exists('label', $value)) ?  $value['label'] : $key) ?>
                <?php elseif ($value[0] == 'string') : ?>
                    <?= $form->field($formModel, $key)->textarea(['rows' => 6, 'class' => 'ckStandartItem'])->label((array_key_exists('label', $value)) ?  $value['label'] : $key) ?>
                <?php endif ?>
            </div>
        <?php endforeach ?>

        <?= $form->field($formModel, 'widget')->hiddenInput()->label(false) ?>
        <?= $form->field($formModel, 'url')->hiddenInput()->label(false) ?>
        <div class="form-group mt-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
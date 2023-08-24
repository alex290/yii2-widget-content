<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="card">
    <div class="card-header position-relative">
        <h5>Добавить <?= $widget['name'] ?></h5>
        <button class="btn_setting_pages_close" onclick="widgetClose()"><i class="far fa-times-circle"></i></button>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'action' => "/widget-content/admin/new",
        ]) ?>
        <?php if (array_key_exists('fields', $widget)) : ?>
            <?php foreach ($widget['fields'] as $key => $value) : ?>
                <?php if ($value[0] == 'image') : ?>
                    <?= $form->field($formModel, $key)->fileInput(['class' => 'image-fileinput']) ?>
                <?php elseif ($value[0] == 'string' && array_key_exists('max', $value)) : ?>
                    <?= $form->field($formModel, $key)->textInput() ?>
                <?php elseif ($value[0] == 'integer') : ?>
                    <?= $form->field($formModel, $key)->textInput(['type' => 'number']) ?>
                <?php elseif ($value[0] == 'file') : ?>
                    <?= $form->field($formModel, $key)->fileInput() ?>
                <?php elseif ($value[0] == 'select') : ?>
                    <?= $form->field($formModel, $key)->dropDownList($widget['fields']['category']) ?>
                <?php elseif ($value[0] == 'string') : ?>
                    <?= $form->field($formModel, $key)->textarea(['rows' => 6, 'class' => 'ckStandart']) ?>
                <?php endif ?>
            <?php endforeach ?>
            <?= $form->field($formModel, 'model_name')->hiddenInput()->label(false) ?>
            <?= $form->field($formModel, 'item_id')->hiddenInput()->label(false) ?>
            <?= $form->field($formModel, 'type')->hiddenInput()->label(false) ?>
            <?= $form->field($formModel, 'widget')->hiddenInput()->label(false) ?>
            <?= $form->field($formModel, 'url')->hiddenInput()->label(false) ?>
        <?php endif ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
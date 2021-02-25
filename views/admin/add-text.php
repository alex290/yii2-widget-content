<?php

use yii\widgets\ActiveForm;

$ckeditorConfig = Yii::$app->getModule('widget-content')->ckeditorConfig;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="d-none ckeditor_config"><?= $ckeditorConfig ?></div>
<div class="card border border-info mt-3">
    <div class="card-body">
        <?= $form->field($model, 'text')->textarea(['rows' => 6, 'class' => 'form-control ckedit'])->label(false) ?>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="button" class="btn btn-outline-dark btn-sm" onclick="removeWidget('<?= $url ?>')"><i class="fas fa-times"></i></button>
        <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-save"></i></button>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php

use yii\widgets\ActiveForm;


?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="card border border-info mt-3">
    <div class="card-body">
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'imageFile')->fileInput(['class' => 'image-fileinput-prew', 'data-image' => $preview]) ?>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="button" class="btn btn-outline-dark btn-sm" onclick="removeWidget('<?= $url ?>')"><i class="fas fa-times"></i></button>
        <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-save"></i></button>
    </div>
</div>

<?php ActiveForm::end(); ?>
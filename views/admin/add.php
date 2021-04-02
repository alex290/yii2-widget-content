<?php

use yii\widgets\ActiveForm;

$ckeditorConfig = Yii::$app->getModule('widget-content')->ckeditorConfig;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?php if (array_key_exists('fields', $widget)) : ?>
<?php foreach ($widget['fields'] as $key => $value) : ?>
    <?php if ($value[0] == 'image') : ?>
        <?= $form->field($formModel, $key)->fileInput() ?>
    <?php else : ?>
        <?php if (array_key_exists('max', $value)) : ?>
            <?= $form->field($formModel, $key)->textInput() ?>
        <?php else : ?>
            <?= $form->field($formModel, $key)->textarea(['rows' => 6]) ?>
        <?php endif ?>
        
    <?php endif ?>
<?php endforeach ?>
<?php endif ?>
<?php ActiveForm::end(); ?>
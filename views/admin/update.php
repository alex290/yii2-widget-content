<?php

use alex290\widgetContent\models\ContentWidgetItem;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;



$item = ContentWidgetItem::find()->where(['content_id' => $model->id])->orderBy(['weight' => SORT_ASC])->all();


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
            'action' => "/widget-content/admin/save",
        ]) ?>
        <?= $form->field($formModel, 'id')->hiddenInput()->label(false) ?>
        <?php foreach ($widget['fields'] as $key => $value) : ?>
            <?php if ($value[0] == 'image') : ?>
                <?= $form->field($formModel, $key)->fileInput(['class' => 'image-fileinput', 'data-image' => $model->getImage()->getPath()]) ?>
            <?php elseif ($value[0] == 'string' && array_key_exists('max', $value)) : ?>
                <?= $form->field($formModel, $key)->textInput() ?>
            <?php elseif ($value[0] == 'select') : ?>
                <?= $form->field($formModel, $key)->dropDownList($widget['fields']['category']) ?>
            <?php elseif ($value[0] == 'integer') : ?>
                <?= $form->field($formModel, $key)->textInput(['type' => 'number']) ?>
            <?php elseif ($value[0] == 'file') : ?>
                <?= $form->field($formModel, $key)->fileInput() ?>
            <?php elseif ($value[0] == 'string') : ?>
                <?= $form->field($formModel, $key)->textarea(['rows' => 6, 'class' => 'ckStandart']) ?>
            <?php endif ?>
        <?php endforeach ?>

        <?= $form->field($formModel, 'widget')->hiddenInput()->label(false) ?>
        <?= $form->field($formModel, 'url')->hiddenInput()->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php if (array_key_exists('item', $widget)) : ?>
            <div class="w-100">
                <?php if ($item != null) : ?>
                    <?php foreach ($item as $key => $valueItem) : ?>
                        <?= $this->render('widgetItem', ['model' => $valueItem, 'url' =>  $formModel->url, 'widget' => $widget]) ?>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="w-100 get_cont_add_widget_item"></div>
            <div class="w-100 d-flex justify-content-center showRemove">
                <button class="btn_add_pages mb-5" onclick='addWidgetItem(<?= Json::encode([$model->id, $widget, $formModel->url]) ?>)'><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" height="16px" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
                    </svg></button>
            </div>
        <?php endif  ?>
    </div>
</div>
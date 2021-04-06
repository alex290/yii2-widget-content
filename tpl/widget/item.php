<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

// debug($model);
// debug($widget);
$data = Json::decode($model->data);
if (array_key_exists('name', $data)) {
    $name = $data['name'];
} elseif (array_key_exists('title', $data)) {
    $name = $data['title'];
}

?>
<div class="col-12 mb-4 get_cont_update_widget_<?= $model->id ?> item-sort" data-id=<?= $model->id ?>>
    <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="curs-point"><svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4 d-flex align-items-end">
                    <h3 class="mb-0"><?= $widget['name'] ?> /</h3>
                    <h5 class="ml-3 mb-0 font-weight-light"><?= $name ?></h5>
                </div>
            </div>
            <div class="d-flex justify-content-end" style="width: 250px;">
                <?= Html::button('<i class="fas fa-edit"></i>', ['class' => 'ml-2 mr-2 btn btn-outline-success showRemove', 'onclick' => 'showEditWidget(' . Json::encode([$model->id, $widget['fields'], Url::to()]) . ')']) ?>
                <?= Html::a('<i class="fas fa-trash-alt"></i>', ['/widget-content/admin/delete', 'id' => $model->id, 'url' => Url::to()], ['class' => 'ml-2 mr-2 btn btn-outline-danger showRemove', 'data-method' => "post", 'data-confirm' => "Вы уверены, что хотите удалить этот элемент?"]); ?>
            </div>
        </div>
    </div>
</div>
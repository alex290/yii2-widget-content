<?php

use alex290\widgetContent\models\ContentWidget;

$models = ContentWidget::find()->andWhere(['modelName'=>$modelName])->andWhere(['itemId'=>$itemId])->orderBy(['weight'=>SORT_ASC])->all();
?>
<?php if ($models != null) : ?>
    <?php foreach ($models as $key => $widget) : ?>
        <div class="card" data-id=<?= $widget->id ?>>
            <?php if ($widget->type == 1) : ?>
                <?= $this->render('widget/text', [
                    'widget' => $widget,
                ]) ?>
            <?php elseif ($widget->type == 2) : ?>
                <?= $this->render('widget/image', [
                    'widget' => $widget,
                ]) ?>
            <?php elseif ($widget->type == 3) : ?>
                <?= $this->render('widget/doc', [
                    'widget' => $widget,
                ]) ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
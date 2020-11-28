Widget content
==============
Widget content

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist alex290/yii2-widget-content "*"
```

or add

```
"alex290/yii2-widget-content": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

в конфиге web.php прописать

    'modules' => [
        'widget-content' => [
            'class' => 'alex290\widgetContent\Module',
            'path' => 'upload', //path to files
        ],
    ],

run migrate

php yii migrate/up --migrationPath=@vendor/alex290/yii2-widget-content/migrations

attach behaviour to your model (be sure that your model has "id" property)

    public function behaviors()
    {
        return [
            'widget' => [
                'class' => 'alex290\widgetContent\behaviors\Behave',
            ]
        ];
    }


Вывести виджет в админке

    <?php if (!$model->isNewRecord) : ?>
        <?= $model->getWidget() ?>
    <?php endif ?>


Получить массив объектов виджетов данной модели

    $model->getContent();


Удалить виджеты

    $model->removeWidgetAll();

    $model->removeWidget($id);
    
Выводить записи на странице
    
    <?php if ($model->getContent() != null) : ?>
        <?php foreach ($model->getContent() as $key => $widget) : ?>
                <?php if ($widget->type == 1) : ?>
                    <?php $data = Json::decode($widget->data) ?>
                    <!-- Выводим текст ($data['text']) -->
                <?php elseif ($widget->type == 2) : ?>
                    <?php $data = Json::decode($widget->data) ?>
                    <!-- Выводим изображение -->
                    <!-- $widget->getImage()->GetPath() -->
                    <!-- Заголовок изображения ($data['title']) -->
                <?php elseif ($widget->type == 3) : ?>
                    <?php $data = Json::decode($widget->data) ?>
                    <!-- Выводим файлы -->
                    <a href="/web/<?= $data['file'] ?>" download="<?= $data['fileName'] ?>"><?= $data['title'] ?></a>
                <?php endif ?>

        <?php endforeach ?>
    <?php endif ?>
    

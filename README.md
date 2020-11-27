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
            'imagesPath' => 'upload/images', //path to images
        ],
    ],

run migrate

php yii migrate/up --migrationPath=@vendor/alex290/yii2-widget-content/migrations

attach behaviour to your model (be sure that your model has "id" property)

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'alex290\widgetContent\behaviors\Behave',
            ]
        ];
    }


Вывести виджет в админке

    <?php if (!$model->isNewRecord) : ?>
        <?= $model->getWidget() ?>
    <?php endif ?>
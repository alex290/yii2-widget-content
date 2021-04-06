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
            'ckeditorPath' => '/web/lib/ckeditor/ckeditor.js', // Путь к внешнему Ckeditor - Необязательно
            'ckeditorConfig' => '/web/lib/ckeditor/config-st.js', // Путь к конфигурации внешнего Ckeditor  - Необязательно
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

    $widget = [
        'text' => [
            'name' => 'Текст',
            'preview' => '/web/images/widget/header.png',
            'fields' => [
                'name' => ['string', 'max' => 255],
                'text' => ['string'],
                'image' => ['image'],
            ]
        ],
		...
        'galery' => [ // Ключ уникальный поля 
            'name' => 'Галерея', // Название виджета
            'preview' => '/web/images/widget/textImageTwo.png', // Путь к превьюшке
            'fields' => [
                'name' => ['string', 'max' => 255],  // Тип поля
                'text' => ['string'], // Тип поля
            ],
            'item' => [ // Дополнительные поля (Например в галлереи несколько картинок)
                'name' => ['string', 'max' => 255], 
                'image' => ['image'],
            ]
        ],
    ];

----------

Типы полей:

['string', 'max' => 255] - Текстовое поле

['string'] - Текстовая область

['image'] - Изображение

['file'] - Файлы

['select'] - Список 

    ...
    'category' => ['select', [
        '44' => 'News',
        '55' => 'Information',
    ]], 

----------


    <?php if (!$model->isNewRecord) : ?>
    		<?= $model->getWidget($widget) ?>
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
    

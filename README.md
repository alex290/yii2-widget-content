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

Подключить внешне Ckeditor 5 classic

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

Или скачать сборку и подключить по инструкции из документации Ckeditor https://ckeditor.com/docs/

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

['integer'] - Целое число

['image'] - Изображение

['file'] - Файл 

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
        <?php foreach ($model->getContent() as $widget) : ?>
            <div class="row">
                <?php
                $element = $widget['model']; // Основной виджет
		$element->type // Тип виджета для разделения секций
                $elementItem = $widget['item']; // Элементы виджета
                $data = Json::decode($element->data); // Поля виджета
                ?>
                <?php if ($element->getImage()->getPrimaryKey() > 0) : // Вывод изображения ?>
                    <img src="/web/<?= $element->getImage()->getPath() ?>" alt="">
                <?php endif ?>
                <?php if (!empty($elementItem)) : ?>
                    <?php foreach ($elementItem as $widgetItem) : ?>
                        <?php $dataItem = Json::decode($widgetItem->data); // Поля элемента виджета  ?>
                        <?php if ($widgetItem->getImage()->getPrimaryKey() > 0) : // Вывод изображения ?>
                            <img src="/web/<?= $widgetItem->getImage()->getPath() ?>" alt="">
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
    
Вывод файла

    <a href="/web/<?= $data['file']['patch'] ?>" download="<?= $data['file']['filename'] ?>">Поле с названием</a>
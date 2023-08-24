<?php


namespace alex290\widgetContent\assets;

use Yii;
use yii\web\AssetBundle;



/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ContWidgetAsset extends AssetBundle
{
    public $sourcePath = '@alex290/widgetContent/assets/scr';
    public $css = [
        'fileinput/css/fileinput.css',
        'fileinput/themes/explorer-fas/theme.css',
        'css/slick.css',
        'css/main.css',
    ];
    public $js = [
        'js/Sortable.js',
        'js/slick.min.js',
        'fileinput/js/fileinput.js',
        'fileinput/js/locales/ru.js',
        'fileinput/themes/fas/theme.js',
        'fileinput/themes/explorer-fas/theme.js',
        'js/widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

     public function init()
    {
        parent::init();
        
    }
    
}

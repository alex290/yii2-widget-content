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
        'css/jquery-ui.min.css',
        'css/main.css',
    ];
    public $js = [
        'fileinput/js/fileinput.js',
        'fileinput/js/locales/ru.js',
        'fileinput/themes/fas/theme.js',
        'fileinput/themes/explorer-fas/theme.js',
        // 'ckeditor/ckeditor.js',
        'js/jquery-ui.min.js',
        'js/widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    protected function ckeditor()
    {
        $ckeditor = 'ckeditor/ckeditor.js';
        $ckeditorPath = Yii::$app->getModule('widget-content')->ckeditorPath;

        if ($ckeditorPath) {
            $ckeditor = $ckeditorPath;
        }
        $this->js[] = $ckeditor;
    }

    public function init()
    {
        parent::init();
        $this->ckeditor();
    }
    
}

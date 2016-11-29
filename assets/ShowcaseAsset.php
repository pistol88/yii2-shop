<?php
namespace pistol88\shop\assets;

use yii\web\AssetBundle;

class ShowcaseAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/showcase.js',
    ];

    public $css = [
        'css/showcase.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}

<?php
namespace pistol88\shop\assets;

use yii\web\AssetBundle;

class CreateOutcomingAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    
    public $js = [
        'js/createoutcoming.js',
    ];

    public $css = [
        
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }

}

<?php
namespace pistol88\shop;

use yii\base\BootstrapInterface;
use yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(!$app->has('stock')) {
            $app->set('stock', ['class' => 'pistol88\shop\Stock']);
        }
    }
}
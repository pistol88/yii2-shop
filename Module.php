<?php
namespace pistol88\shop;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['admin', 'superadmin'];
    public $modelMap = [];
    
    public function init()
    {
        if(empty($this->modelMap)) {
            $this->modelMap = [
                'product' => '\pistol88\shop\models\Product',
                'category' => '\pistol88\shop\models\Category',
                'producer' => '\pistol88\shop\models\Producer',
                'price' => '\pistol88\shop\models\Price'
            ];
        }
        
        parent::init();
    }
    
    public function getService($key)
    {
        $model = $this->modelMap[$key];
        
        return new $model;
    }
}

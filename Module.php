<?php
namespace pistol88\shop;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['admin', 'superadmin'];
    public $modelMap = [];
    public $defaultTypeId = null;
    public $priceType = null; //callable, возвращающая type_id цены
    public $categoryUrlPrefix = '/shop/category/view';
    public $productUrlPrefix = '/shop/product/view';
    
    const EVENT_PRODUCT_CREATE = 'create_product';
    const EVENT_PRODUCT_DELETE = 'delete_product';
    const EVENT_PRODUCT_UPDATE = 'update_product';
    
    public function init()
    {
        if(empty($this->modelMap)) {
            $this->modelMap = [
                'product' => '\pistol88\shop\models\Product',
                'category' => '\pistol88\shop\models\Category',
                'incoming' => '\pistol88\shop\models\Incoming',
                'outcoming' => '\pistol88\shop\models\Outcoming',
                'producer' => '\pistol88\shop\models\Producer',
                'price' => '\pistol88\shop\models\Price',
                'stock' => '\pistol88\shop\models\Stock',
                'modification' => '\pistol88\shop\models\Modification',
            ];
        }
        
        parent::init();
    }
    
    //возвращает type_id цены, которую стоит отобразить покупателю
    public function getPriceTypeId($product = null)
    {
        if(is_callable($this->priceType))
        {
            $priceType = $this->priceType;
            return $values($product);
        }
        
        return $this->defaultTypeId;
    }
    
    public function getService($key)
    {
        $model = $this->modelMap[$key];
        
        return new $model;
    }
}

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
    public $oneC = null;
    public $userModel = null;
    public $users = [];
    public $menu = [
        [
            'label' => 'Товары',
            'url' => ['/shop/product/index'],
        ],
        [
            'label' => 'Категории',
            'url' => ['/shop/category/index'],
        ],
        [
            'label' => 'Производители',
            'url' => ['/shop/producer/index'],
        ],
        [
            'label' => 'Склады',
            'url' => ['/shop/stock/index'],
        ],
        [
            'label' => 'Типы цен',
            'url' => ['/shop/price-type/index'],
        ],
    ];
	
    public $productColumnsFile = null;
    public $productColumns = null;
    
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
        
        if(!$this->userModel) {
            if($user = yii::$app->user->getIdentity()) {
                $this->userModel = $user::className();
            }
        }
        
        if(is_callable($this->users)) {
            $func = $this->users;
            $this->users = $func();
        }
        
        if(!$this->productColumnsFile) {
            $this->productColumnsFile = __DIR__ . '/settings/productsGridViewColumns.php';
        }
        
        if(!$this->productColumns) {
            $this->productColumns = require $this->productColumnsFile;
        }
        
        parent::init();
    }
    
    //возвращает type_id цены, которую стоит отобразить покупателю
    public function getPriceTypeId($product = null)
    {
        if(is_callable($this->priceType)) {
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

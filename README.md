Внимание!
==========
Разработка модуля с 24.04.2017 ведется здесь: [dvizh/yii2-shop](https://github.com/dvizh/yii2-shop). Рекомендую устанавливать модуль из репозитория Dvizh, именно там находится последняя версия.

Yii2-shop
==========
Модуль представляет из себя бекенд для Интернет-магазина.

![yii2-shop](https://cloud.githubusercontent.com/assets/8104605/15448447/751a647a-1f7b-11e6-87e7-c7354306f10e.png)

В состав входит возможность управлять (CRUD):

* Категориями
* Производителями
* Товарами
* Ценами
* Фильтрами (опциями)
* Дополнительными полями

Если есть необходимость, можно также подтянуть мои другие модули:

* [pistol88/yii2-cart](https://github.com/pistol88/yii2-cart) - корзина
* [pistol88/yii2-order](https://github.com/pistol88/yii2-order) - заказ
* [pistol88/yii2-promocode](https://github.com/pistol88/yii2-promocode) - промокоды

Установка
---------------------------------

Рекомендую устанавливать в common/modules/pistol88:

```
git clone https://github.com/pistol88/yii2-shop.git
```

И подключать через psr-4 секцию composer.json:

```
"autoload": {
    "psr-4": {
        "pistol88\\shop\\": "common/modules/pistol88/yii2-shop"
    }
}
```

Модуль зависит от многих других пакетов, скопируйте их из моего в свой composer.json в секцию require. После этого не забудьте выполнить composer update и миграции каждого модуля.

Если хотите установить в папку vendor через composer и ничего не менять потом, устанавливайте стандартно: 'php composer require pistol88/yii2-shop' и 'php composer update' в командной строке.

Миграция:

```
php yii migrate --migrationPath=vendor/pistol88/yii2-shop/migrations
```

Настройка
---------------------------------

В конфиг (скорее всего, bootstrap.php) добавить:

```
Yii::setAlias('@storageUrl','/frontend/web/images');
```

В секцию modules конфига добавить:

```
    'modules' => [
        //..
        'shop' => [
            'class' => 'pistol88\shop\Module',
            'adminRoles' => ['administrator', 'superadmin', 'admin'],
        ],
        'filter' => [
            'class' => 'pistol88\filter\Module',
            'adminRoles' => ['administrator'],
            'relationFieldName' => 'category_id',
            'relationFieldValues' =>
                function() {
                    return \pistol88\shop\models\Category::buildTextTree();
                },
        ],
        'field' => [
            'class' => 'pistol88\field\Module',
            'relationModels' => [
                'pistol88\shop\models\Product' => 'Продукты',
                'pistol88\shop\models\Category' => 'Категории',
                'pistol88\shop\models\Producer' => 'Производители',
            ],
            'adminRoles' => ['administrator'],
        ],
        'relations' => [
            'class' => 'pistol88\relations\Module',
            'fields' => ['code'],
        ],
        'gallery' => [
            'class' => 'pistol88\gallery\Module',
            'imagesStorePath' => dirname(dirname(__DIR__)).'/storage/web/images/store',
            'imagesCachePath' => dirname(dirname(__DIR__)).'/storage/web/images/cache',
            'graphicsLibrary' => 'GD',
            'placeHolderPath' => dirname(dirname(__DIR__)).'/storage/web/images/placeHolder.png',
        ],
        //..
    ]
```

В shop можно передать modelMap, где указать нужные вам модели. Также можно указать стандартные yiiшные controllerMap, viewPath, чтобы подменить контроллеры и вьюхи своими в процессе развития вашего магазина.

В секцию components:

```
    'components' => [
        //..
        'fileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/source',
            'filesystem'=> function() {
                $adapter = new \League\Flysystem\Adapter\Local(dirname(dirname(__DIR__)).'/frontend/web/images/source');
                return new League\Flysystem\Filesystem($adapter);
            },
        ],
        //..
    ]
```

Использование
---------------------------------

* ?r=shop/product - продукты
* ?r=shop/category - категории
* ?r=shop/producer - производители
* ?r=filter/filter - фильтры (опции)
* ?r=field/field - доп. поля

Виджеты
---------------------------------

* pistol88\shop\widgets\ShowPrice - передается 'model', выводит цену. Связан с pistol88\cart\widgets\ChangeOptions через jQuery триггер и может определять, какая модификация выбрана и динамически менять цену.

Пример карточки товара со всеми виджетами магазина и корзины, которые работают сообща и динамически меняют данные друг-друга.


```
<?php
use pistol88\shop\widgets\ShowPrice;
use pistol88\cart\widgets\BuyButton;
use pistol88\cart\widgets\TruncateButton;
use pistol88\cart\widgets\CartInformer;
use pistol88\cart\widgets\ElementsList;
use pistol88\cart\widgets\ChangeCount;
use pistol88\cart\widgets\ChangeOptions;

$product = \pistol88\shop\models\Product::findOne(1); //from controller
?>
<div class="site-index">
    <h1><?=$product->name;?></h1>
    
    <h2>Shop</h2>
    <div class="block row">
        <h3>ShowPrice</h3>
        <?=ShowPrice::widget(['model' => $product]);?>
    </div>
    
    <h2>Cart</h2>
    <div class="block row">
        <div class="col-md-3">
            <h3>ChangeCount</h3>
            <?=ChangeCount::widget(['model' => $product]);?>
        </div>
        <div class="col-md-3">
            <h3>ChangeOptions</h3>
            <?=ChangeOptions::widget(['model' => $product]);?>
        </div>
        <div class="col-md-3">
            <h3>BuyButton</h3>
            <?=BuyButton::widget(['model' => $product]);?>
        </div>
        <div class="col-md-3">
            <h3>TruncateButton</h3>
            <?=TruncateButton::widget();?>
        </div>
        <div class="col-md-3">
            <h3>CartInformer</h3>
            <?=CartInformer::widget();?>
        </div>
        <div class="col-md-3">
            <h3>ElementsList</h3>
            <?=ElementsList::widget(['type' => 'dropdown']);?>
        </div>
    </div>
    
    <style>
        .block {
            border: 2px solid blue;
        }
    </style>
    
</div>

```

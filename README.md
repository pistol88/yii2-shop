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

Установка
---------------------------------

Рекомендую устанавливать в common/modules/pistol88:

```
git clone https://github.com/pistol88/yii2-shop.git
```

И подключать через psr-4 секцию composer.json:

```
{
    "autoload": {
        "psr-4": {
            "pistol88\\shop": "common/modules/pistol88/shop",
        }
    }
}
```

Модуль зависит от многих других пакетов, скопируйте их в свой composer.json в секцию require. После этого не забудьте выполнить composer update.

Если хотите установить в папку vendor через composer и ничего не менять потом, устанавливайте стандартно: 'php composer require pistol88/yii2-shop' и 'php composer update' в командной строке.

Миграция:

```
php yii migrate --migrationPath=vendor/pistol88/yii2-shop/migrations
```

Настройка
---------------------------------

В секцию modules конфига добавить:

```
    'modules' => [
        //..
        'shop' => [
            'class' => 'pistol88\shop\Module',
            'adminRoles' => ['administrator'],
        ],
        'filter' => [
            'class' => 'pistol88\filter\Module',
            'adminRoles' => ['administrator'],
            'relationModel' => 'pistol88\shop\models\Product',
            'relationFieldName' => 'category_id',
            'relationFieldValues' =>
                function() {
                    return \pistol88\shop\models\buldTextTree();
                },
        ],
        'relations' => [
            'class' => 'pistol88\relations\Module',
            'fields' => ['code'],
        ],
        'yii2images' => [
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
                $adapter = new \League\Flysystem\Adapter\Local('some/path/to/storage');
                return new League\Flysystem\Filesystem($adapter);
            },
        ],
        //..
    ]
```

Использование
---------------------------------
* ?r=shop/product
* ?r=shop/category
* ?r=shop/producer
* ?r=filter/filter

Виджеты
---------------------------------
Виджеты в разработке.

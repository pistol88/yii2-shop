Yii2-shop
==========
Модуль представляет из себя бекенд для Интернет-магазина.

В состав входит возможность управлять (CRUD):

* Категориями
* Производителями
* Товарами
* Ценами

Установка
---------------------------------

Выполнить команду

```
php composer require pistol88/yii2-shop "*"
```

Или добавить в composer.json

```
"pistol88/yii2-shop": "*",
```

И выполнить

```
php composer update
```

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

Виджеты
---------------------------------
Виджеты в разработке.

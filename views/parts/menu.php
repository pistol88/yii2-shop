<?php
use yii\bootstrap\Nav;
?>
<?= Nav::widget([
    'items' => [
        [
            'label' => 'Товары',
            'url' => ['/shop/product/index'],
        ],
        [
            'label' => 'Поступление',
            'url' => ['/shop/incoming/create'],
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
            'label' => 'Типы цен',
            'url' => ['/shop/price-type/index'],
        ],
    ],
    'options' => ['class' =>'nav-pills'],
]); ?>
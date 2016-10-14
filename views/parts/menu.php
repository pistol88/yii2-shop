<?php
use yii\bootstrap\Nav;
?>
<?= Nav::widget([
    'items' => yii::$app->getModule('shop')->menu,
    'options' => ['class' =>'nav-pills'],
]); ?>
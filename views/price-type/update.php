<?php
use yii\helpers\Html;

$this->title = 'Обновить тип цен: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="price-type-update">
    <div class="shop-menu">
        <?=$this->render('../parts/menu');?>
    </div>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php
use yii\helpers\Html;

$this->title = 'Создать тип цен';
$this->params['breadcrumbs'][] = ['label' => 'Типы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="price-type-create">
    <div class="shop-menu">
        <?=$this->render('../parts/menu');?>
    </div>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

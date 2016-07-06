<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;

$this->title = 'Производители';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="price-type-index">
    <div class="shop-menu">
        <?=$this->render('../parts/menu');?>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?= Html::a('Добавить новый тип', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
            
            'name',
            'sort',
            
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
        ],
    ]); ?>

</div>

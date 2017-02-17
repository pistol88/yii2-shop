<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use pistol88\shop\models\ProductOption;
use pistol88\shop\models\Category;
use pistol88\shop\models\Producer;
use pistol88\shop\models\Price;
use kartik\export\ExportMenu;

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="product-index">
    <div class="shop-menu">
        <?=$this->render('../parts/menu');?>
    </div>

    <div class="row">
        <div class="col-md-1">
            <?= Html::tag('button', 'Удалить', [
                'class' => 'btn btn-success pistol88-mass-delete',
                'disabled' => 'disabled',
                'data' => [
                    'model' => $dataProvider->query->modelClass,
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-2">
            <?php
            $gridColumns = [
                'id',
                'code',
                'category.name',
                'producer.name',
                'name',
                'price',
                'amount',
            ];

            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns
            ]);
            ?>
        </div>
    </div>
    
        <?php if($amount = $dataProvider->query->sum('amount')) { ?>
            <div class="summary">
                Всего товаров:
                <?=$amount;?>
                на сумму
                <?=Price::find()->joinWith('product')->sum("shop_price.price*shop_product.amount");?> руб.
            </div>
        <?php } ?>
    
    <br style="clear: both;"></div>
    <?php
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $productColumns,
    ]); ?>

</div>

<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use pistol88\shop\models\Category;
use pistol88\shop\models\Producer;

$searchModel = new pistol88\shop\models\product\ProductSearch;

return [
    ['class' => '\kartik\grid\CheckboxColumn'],
    ['class' => 'yii\grid\SerialColumn'],
    ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
    'name',
    'code',
    [
        'label' => 'Остаток',
        'content' => function($model) {
            return "<p>{$model->amount} (".($model->amount*$model->price).")</p>";
        }
    ],
    [
        'attribute' => 'images',
        'format' => 'images',
        'filter' => false,
        'content' => function ($model) {
            if($image = $model->getImage()->getUrl('50x50')) {
                return "<img src=\"{$image}\" class=\"thumb\" />";
            }
        }
    ],
    [
        'label' => 'Цена',
        'content' => function ($model) {
            $return = '';
            
            foreach($model->prices as $price) {
                $return .= "<p class=\"productsMenuPrice\"><span title=\"{$price->name}\">{$price->price}</span></p>";
            }
            
            return $return;
        }
    ],
    /*
    [
        'attribute' => 'available',
        'filter' => Html::activeDropDownList(
            $searchModel,
            'available',
            ['no' => 'Нет', 'yes' => 'Да'],
            ['class' => 'form-control', 'prompt' => 'Наличие']
        ),
    ],
    */
    [
        'attribute' => 'category_id',
        'filter' => Html::activeDropDownList(
            $searchModel,
            'category_id',
            Category::buildTextTree(),
            ['class' => 'form-control', 'prompt' => 'Категория']
        ),
        'value' => 'category.name'
    ],
    [
        'attribute' => 'producer_id',
        'filter' => Html::activeDropDownList(
            $searchModel,
            'producer_id',
            ArrayHelper::map(Producer::find()->all(), 'id', 'name'),
            ['class' => 'form-control', 'prompt' => 'Производитель']
        ),
        'value' => 'producer.name'
    ],
    ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
];

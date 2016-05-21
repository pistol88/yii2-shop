<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use pistol88\shop\models\ProductOption;
use pistol88\shop\models\Category;
use pistol88\shop\models\Producer;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\shop\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
            'name',
            [
				'attribute' => 'images',
				'format' => 'images',
                'filter' => false,
				'content' => function ($image) {
                    if($image = $image->getThumb('thumb')) {
                        return "<img src=\"{$image}\" class=\"thumb\" />";
                    }
				}
			],
			[
				'attribute' => 'available',
				'filter' => Html::activeDropDownList(
					$searchModel,
					'available',
					['no' => 'Нет', 'yes' => 'Да'],
					['class' => 'form-control', 'prompt' => 'Наличие']
				),
			],
			[
				'attribute' => 'category_id',
				'filter' => Html::activeDropDownList(
					$searchModel,
					'category_id',
					Category::buldTextTree(),
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
        ],
    ]); ?>

</div>

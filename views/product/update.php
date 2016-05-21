<?php
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\grid\EditableColumn;

/* @var $this yii\web\View */
/* @var $model pistol88\shop\models\Product */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Товар', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="product-update">

    <div class="row">
        <div class="col-lg-7 edit-column">
 
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-lg-5 prices-column">
            <div class="stickyeah">
                <h2>Цены</h2>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width: 20px;']],
                        ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
                        [
                            'class' => EditableColumn::className(),
                            'attribute' => 'name',
                            'url' => ['price/edit-field'],
                            'type' => 'text',
                            'editableOptions' => [
                                'mode' => 'inline',
                            ],
                        ],
                        [
                            'class' => EditableColumn::className(),
                            'attribute' => 'available',
                            'url' => ['price/edit-field'],
                            'type' => 'select',
                            'editableOptions' => [
                                'mode' => 'inline',
                                'source' => ['yes', 'no'],
                            ],
                            'filter' => Html::activeDropDownList(
                                $searchModel,
                                'available',
                                ['no' => 'Нет', 'yes' => 'Да'],
                                ['class' => 'form-control', 'prompt' => 'Наличие']
                            ),
                            'options' => ['style' => 'width: 90px;']
                        ],
                        [
                            'class' => EditableColumn::className(),
                            'attribute' => 'price',
                            'url' => ['price/edit-field'],
                            'type' => 'text',
                            'editableOptions' => [
                                'mode' => 'inline',
                            ],
                            'options' => ['style' => 'width: 70px;']
                        ],
                        ['class' => 'yii\grid\ActionColumn', 'controller' => 'price', 'template' => '{delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 60px;']],
                    ],
                ]); ?>

                <?= $this->render('price/_form', [
                    'model' => $priceModel,
                    'productModel' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>

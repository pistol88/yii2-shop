<?php
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\grid\EditableColumn;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Товар', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="product-update">
    <div class="shop-menu">
        <?=$this->render('../parts/menu');?>
    </div>
    
    <div class="row">
        <div class="col-lg-6 edit-column">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-lg-6 prices-column">
            <div class="stickyeah-no">
                <h2>Цены</h2>
                <?php if($dataProvider->getCount()) { ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width: 20px;']],
                            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 25px;']],
                            [
                                'class' => EditableColumn::className(),
                                'attribute' => 'name',
                                'url' => ['price/edit-field'],
                                'type' => 'text',
                                'filter' => false,
                                'editableOptions' => [
                                    'mode' => 'inline',
                                ],
                                'options' => ['style' => 'width: 75px;']
                            ],
                            [
                                'class' => EditableColumn::className(),
                                'attribute' => 'sort',
                                'url' => ['price/edit-field'],
                                'type' => 'text',
                                'editableOptions' => [
                                    'mode' => 'inline',
                                ],
                                'options' => ['style' => 'width: 49px;']
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
                                'filter' => false, /*Html::activeDropDownList(
                                    $searchModel,
                                    'available',
                                    ['no' => 'Нет', 'yes' => 'Да'],
                                    ['class' => 'form-control', 'prompt' => 'Наличие']
                                ),*/
                                'contentOptions' => ['style' => 'width: 27px;']
                            ],
                            [
                                'class' => EditableColumn::className(),
                                'attribute' => 'price',
                                'url' => ['price/edit-field'],
                                'type' => 'text',
                                'editableOptions' => [
                                    'mode' => 'inline',
                                ],
                                'options' => ['style' => 'width: 40px;']
                            ],
                            ['class' => 'yii\grid\ActionColumn', 'controller' => 'price', 'template' => '{delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 30px;']],
                        ],
                    ]); ?>
                <?php } else { ?>
                    <p style="color: red;">У товара нет цен.</p>
                <?php } ?>
                <?= $this->render('price/_form', [
                    'model' => $priceModel,
                    'productModel' => $model,
                ]) ?>
                
                <?php if($filterPanel = \pistol88\filter\widgets\Choice::widget(['model' => $model])) { ?>
                    <div class="block">
                        <h2>Фильтр</h2>
                        <?=$filterPanel;?>
                    </div>
                <?php } ?>
                
                <?php if($fieldPanel = \pistol88\field\widgets\Choice::widget(['model' => $model])) { ?>
                    <div class="block">
                        <h2>Прочее</h2>
                        <?=$fieldPanel;?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

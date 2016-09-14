<?php
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\grid\EditableColumn;

$this->title = Html::encode($model->name);
\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="product-modification-update">
    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', [
                'model' => $model,
                'productModel' => $productModel,
                'module' => $module,
            ]) ?>
            
            <?php if($filterPanel = \pistol88\filter\widgets\Choice::widget(['model' => $model->product])) { ?>
                <div class="block">
                    <h2>Фильтр</h2>
                    <?=$filterPanel;?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

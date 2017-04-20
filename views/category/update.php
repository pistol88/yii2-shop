<?php
use yii\helpers\Html;

$this->title = 'Обновить категорию: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php if($fieldPanel = \pistol88\field\widgets\Choice::widget(['model' => $model])) { ?>
        <div class="block">
            <h2>Прочее</h2>
            <?=$fieldPanel;?>
        </div>
    <?php } ?>
    
</div>

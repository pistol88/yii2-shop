<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pistol88\shop\models\Page */

$this->title = 'Обновить производителя: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Производители', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="page-update">

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

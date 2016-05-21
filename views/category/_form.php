<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use pistol88\shop\models\Category;
use pistol88\gallery\widgets\Gallery;
use kartik\select2\Select2;
use pistol88\seo\widgets\SeoForm;

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    
    <?= $form->field($model, 'slug')->textInput(['placeholder' => 'Не обязательно']) ?>
	
	<?= $form->field($model, 'sort')->textInput() ?>
	
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'parent_id')
            ->widget(Select2::classname(), [
                'data' => Category::buildTextTree(null, 1, [$model->id]),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите категорию ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    
    <?=Gallery::widget(['model' => $model, 'form' => $form, 'mode' => 'single', 'inAttribute' => 'image']);?>

    <?=\pistol88\seo\widgets\SeoForm::widget([
        'model' => $model, 
        'form' => $form, 
    ]); ?>
        
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

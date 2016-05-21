<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use pistol88\shop\models\Category;
use pistol88\shop\models\Producer;
use pistol88\gallery\widgets\Gallery;
use kartik\select2\Select2;
use pistol88\seo\widgets\SeoForm;

\pistol88\shop\assets\BackendAsset::register($this);
?>

<div class="product-form">
    <div class="form-group shop-control">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-default" href="<?=Url::toRoute(['product/delete', 'id' => 8]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-6 col-xs-6">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-lg-6 col-xs-6">
            <?= $form->field($model, 'code')->textInput() ?>
        </div>
    </div>
	
    <div class="row">
        <div class="col-lg-6 col-xs-6">
            <?= $form->field($model, 'available')->dropDownList(['yes' => 'Да', 'no' => 'Нет', ], ['prompt' => '']) ?>
        </div>
        <div class="col-lg-6 col-xs-6">
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
    </div>
	
    <div class="row">
        <div class="col-lg-6 col-xs-6">
            <?= $form->field($model, 'category_id')
                ->widget(Select2::classname(), [
                'data' => Category::buldTextTree(),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите категорию ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            
            <?= $form->field($model, 'producer_id')
                ->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Producer::find()->all(), 'id', 'name'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите бренд ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-lg-6 col-xs-6">
            <?= $form->field($model, 'category_ids')->dropDownList(Category::buldTextTree(), ['multiple' => true, 'size' => 5])->label('Все категории') ?>
        </div>
    </div>

    <?php echo $form->field($model, 'text')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options'=>[
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'imageUpload' => Url::toRoute(['tools/upload-imperavi'])
            ]
        ]
    ) ?>

    <?= $form->field($model, 'short_text')->textInput(['maxlength' => true]) ?>

	<?=Gallery::widget(['model' => $model, 'form' => $form, 'inAttribute' => 'images']); ?>
    
    <?= SeoForm::widget([
        'model' => $model, 
        'form' => $form,
    ]); ?>
    
    <h3>Связанные продукты</h3>
    <?=\pistol88\relations\widgets\Constructor::widget(['model' => $model]);?>
    

    <div class="form-group shop-control">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-default" href="<?=Url::toRoute(['product/delete', 'id' => 8]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
    </div>

    <?php ActiveForm::end(); ?>

</div>

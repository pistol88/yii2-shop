<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use pistol88\shop\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel pistol88\shop\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <p>
        <a href="?view=tree" <?php if(yii::$app->request->get('view') == 'tree' | yii::$app->request->get('view') == '') echo ' style="font-weight: bolder;"'; ?>>Деревом</a> | 
        <a href="?view=list" <?php if(yii::$app->request->get('view') == 'list') echo ' style="font-weight: bolder;"'; ?>>Списком</a>
    </p>

    <?php
    if(isset($_GET['view']) && $_GET['view'] == 'list') {
        $categories = GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
                'name',
                [
                    'attribute' => 'image',
                    'format' => 'image',
                    'filter' => false,
                    'content' => function ($image) {
                        if($image = $image->getThumb('thumb')) {
                            return "<img src=\"{$image}\" class=\"thumb\" />";
                        }
                    }
                ],
                [
                    'attribute' => 'parent_id',
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'parent_id',
                        Category::buildTextTree(),
                        ['class' => 'form-control', 'prompt' => 'Категория']
                    ),
                    'value' => 'category.name'
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
            ],
        ]);
    } else {
        $categories = \pistol88\tree\widgets\Tree::widget(['model' => new \pistol88\shop\models\Category()]);
    }
    
    echo $categories;
    ?>

</div>

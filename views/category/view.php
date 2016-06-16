<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use pistol88\cart\widgets\BuyButton;

if(!$title = $model->seo->title) {
    $title = $model->name;
}

if(!$description = $model->seo->description) {
    $description = 'Категория '.$model->name;
}

if(!$keywords = $model->seo->keywords) {
    $keywords = 'категория, '.$model->name;
}

$this->title = $title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $description,
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $keywords,
]);

$childs = $model->childs;
if(empty($childs) && $parent = $model->parent) {
    $childs = $parent->childs;
}
?>

<?php if($childs) { ?>
    <div class="container-fluid menu">
        <div class="row categories">
        <?php $i = 1; foreach($childs as $subCategory) { $i++; ?>
            <?php if($i == 6) { echo '</div><div class="row categories">'; $i = 1; } ?>
            <div class="col-md-2">
                <a href="<?=$subCategory->link;?>" title="<?=$subCategory->name;?>" <?php if($subCategory->id == $model->id) echo ' class="active"'; ?>>
                    <?php if($image = $subCategory->thumb) { ?>
                        <img src="<?=$image;?>" width="187" height="187" alt="<?=$subCategory->name;?>" title="<?=$subCategory->name;?>">
                    <?php } else { ?>
                       <?=$subCategory->name;?> 
                    <?php } ?>
                </a>
            </div>
        <?php } ?>
        </div>
    </div>
<?php } ?>

<div class="container-fluid recomend">
	<div class="row listing">
        <?php foreach($model->products as $product) { ?>
            <div class="col-md-2">
                <div class="product">
                    <a href="#product<?=$product->id;?>" data-toggle="modal" data-target="#product<?=$product->id;?>">
                        <?php if($image = $product->image->getUrl('200x133')) { ?>
                            <img src="<?=$image;?>" alt="<?=$product->name;?>" title="<?=$product->name;?>" width="200" height="133">
                        <?php } ?>
                    </a>

                    <h5>
                        <a href="#product<?=$product->id;?>" data-toggle="modal" data-target="#product<?=$product->id;?>"><?=$product->name;?></a>
                    </h5>
                    
                    <p><?=$product->short_text;?></p>
                    <?php if($price = $product->price) { ?>
                        <div class="price">
                            <span><?=$price;?></span>
                            грн
                        </div>
                    <?php } ?>
                    <?php if($weight = $product->getField('weight')) { ?>
                        <div class="weight"><?=$weight;?> <?=$product->getField('units');?></div>
                    <?php } ?>
                    <?php if($price = $product->price) { ?>
                        <?= BuyButton::widget([
                           'model' => $product,
                           'cssClass' => '',
                           'text' => 'Заказать',
                           'htmlTag' => 'button',
                       ]) ?>
                    <?php } ?>
                </div>
                <?php if($price = $product->price) { ?>
                    <div class="price"><?=$product->price;?> грн</div>
                <?php } ?>
                <?php if($weight = $product->getField('weight')) { ?>
                    <div class="weight"><?=$weight;?> <?=$product->getField('units');?></div>
                <?php } ?>
            </div>
        <?php } ?>
	</div>
</div>

<?php foreach($model->products as $product) { ?>
    <div class="modal fade product-window" id="product<?=$product->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-8">
                        <?php if($image = $product->thumb) { ?>
                            <img src="<?=$image;?>" alt="" title="<?=$product->name;?>" width="500">
                        <?php } ?>
                        <h4><?=$product->name;?></h4>
                        <?=$product->text;?>
                        <p>
                            <?php if($weight = $product->getField('weight')) { ?>
                                <strong><?=$weight;?></strong> <?=$product->getField('units');?>
                            <?php } ?>
                            <?php if($count = $product->getField('count')) { ?>
                                <strong><?=$count;?></strong> шт.
                            <?php } ?>
                        </p>
                        <?php if($ingredients = $product->getOption('ingredients', true)) { ?>
                            <?php foreach($ingredients as $ingredient) { ?>
                                <div class="col-md-3 ingrid">
                                    <img src="<?=$ingredient->getImage()->url;?>" width="50" alt="<?=$ingredient->value;?>">
                                    <p><?=$ingredient->value;?></p>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 bg-green">
                        <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="change-count">
                            <div class="col-md-3 col-md-offset-1">
                                <a href="#" data-id="<?=$product->id;?>" class="minus">-</a>
                            </div>
                            <div class="col-md-4">
                                <span class="count">1</span>
                            </div>
                            <div class="col-md-3">
                                <a href="#" data-id="<?=$product->id;?>" class="plus">+</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php if($price = $product->price) { ?><span><?=$price;?></span> грн<?php } ?>
                            <?php if($weight = $product->getField('weight')) { ?>
                                <span><?=$weight;?></span> <?=$product->getField('units');?>
                            <?php } ?>
                            <?php if($count = $product->getField('count')) { ?>
                                <strong><?=$count;?></strong> шт.
                            <?php } ?>
                        </div>
                        <?php if($price = $product->price) { ?>
                            <div class="col-md-12">
                                <?= BuyButton::widget([
                                   'model' => $product,
                                   'cssClass' => 'btn-light buy-'.$product->id,
                                   'text' => 'Заказать',
                                   'htmlTag' => 'a',
                               ]) ?>
                            </div>
                        <?php } ?>
                        
                        <?php if($relations = $product->relations) { ?>
                            <div class="col-md-12 zag">
                                Рекомендуем к заказу
                            </div>
                            <?php foreach($relations as $relation) { ?>
                                <div class="col-md-12 recomend-add">
                                    <div class="col-md-4">
                                        <?php if($image = $relation->getThumb('thumb')) { ?>
                                            <img src="<?=$image;?>" alt="<?=$relation->name;?>" title="<?=$relation->name;?>" width="60" height="60">
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-8">
                                        <p><?=$relation->name;?></p>
                                        <?php if($price = $relation->price) { ?>
                                            <div class="col-md-6"><?=$price;?> грн</div>
                                        <?php } ?>
                                            
                                        <?php if($weight = $relation->getField('weight')) { ?>
                                            <div class="col-md-6"><?=$weight;?> <?=$product->getField('units');?></div>
                                        <?php } ?>
                                    </div>
                                    <?php if($price = $relation->price) { ?>
                                        <?= BuyButton::widget([
                                           'model' => $product,
                                           'cssClass' => 'light',
                                           'text' => 'Заказать',
                                           'htmlTag' => 'button',
                                       ]) ?>
                                   <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>				
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
namespace pistol88\shop\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii;

class ShowPrice extends \yii\base\Widget
{
    public $model = NULL;
    public $htmlTag = 'span';
    public $cssClass = '';

    public function init()
    {
        \pistol88\shop\assets\WidgetAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        return Html::tag(
                $this->htmlTag,
                $this->model->getPrice(),
                ['class' => "pistol88-shop-price {$this->cssClass}"]
            );
    }
}

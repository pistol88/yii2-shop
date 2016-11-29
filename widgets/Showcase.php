<?php
namespace pistol88\shop\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use pistol88\shop\models\Category;
use pistol88\shop\models\Product;
use pistol88\shop\models\Modification;

class Showcase extends \yii\base\Widget
{
    public function init()
    {
        \pistol88\shop\assets\ShowcaseAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        $categories = Category::find()->all();

        return $this->render('showCase', [
            'categories' => $categories
        ]);
    }
}

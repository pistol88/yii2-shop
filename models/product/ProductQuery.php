<?php
namespace pistol88\shop\models\product;

use pistol88\shop\models\Category;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    function behaviors()
    {
       return [
           'filter' => [
               'class' => 'pistol88\filter\behaviors\Filtered',
           ],
           'field' => [
               'class' => 'pistol88\field\behaviors\Filtered',
           ],
       ];
    }
    
    public function available()
    {
         return $this->andwhere("`available` = 'yes'");
    }
    
    public function category($childCategoriesIds)
    {
         return $this->andwhere(['category_id' => $childCategoriesIds]);
    }
}
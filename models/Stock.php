<?php
namespace pistol88\shop\models;

use Yii;
use yii\helpers\Url;
use pistol88\shop\models\StockToProduct;
use yii\db\ActiveQuery;

class Stock extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%shop_stock}}';
    }
    
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['text', 'address', 'name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Адрес',
            'name' => 'Название',
            'text' => 'Текст',
        ];
    }
    public function getProductAmount($productId){
        if($amount = StockToProduct::find('amount')->where(['product_id' => $productId, 'stock_id' => $this->id])->one()->amount) {
            return $amount;
        } else {
            return 0;
        }
    }
    public static function editField($id, $value, $productId) 
    {
        $stock = Stock::findOne($id);
        if($productAmount = StockToProduct::find('amount')->where(['product_id' => $productId, 'stock_id' => $id])->one()){
            $productAmount->amount = $value;
            $productAmount->save();
        } else {
            $productAmount = new StockToProduct();
            $productAmount->amount = $value;
            $productAmount->product_id = $productId;
            $productAmount->stock_id = $id;
            $productAmount->save();
        }
        
    }
}

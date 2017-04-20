<?php
namespace pistol88\shop;

use pistol88\shop\models\Stock as StockModel;
use pistol88\shop\models\Outcoming;
use yii\base\Component;
use yii;

class Stock extends Component
{
    public function getAvailable($userId = null)
    {
        return StockModel::getAvailable($userId);
    }
    
    public function getStock($id)
    {
        return StockModel::findOne($id);
    }
	
    public function outcoming($stockId, $productId, $count, $orderId = null)
    {
        $return = false;
        
        if($stock = $this->getStock($stockId)) {
            $outcoming = new Outcoming;
            $outcoming->user_id = yii::$app->user->id;
            $outcoming->date = time();
            $outcoming->count = $count;
            $outcoming->stock_id = $stockId;
            $outcoming->product_id = $productId;
            $outcoming->order_id = $orderId;
            
            if($outcoming->save()) {
                $return = $stock->minusAmount($productId, $count);
            }
        }
        
        return $return;
    }
    
    public function getOutcomingsByOrder($orderId, $productId)
    {
        return Outcoming::find()->where(['order_id' => $orderId, 'product_id' => $productId])->all();
    }
}

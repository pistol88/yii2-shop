<?php
namespace pistol88\shop\models;

use Yii;
use pistol88\shop\models\Product;

class Price extends \yii\db\ActiveRecord implements \pistol88\cart\interfaces\CartElement 
{
    public static function tableName()
    {
        return '{{%shop_price}}';
    }

    public function rules()
    {
        return [
            [['name', 'product_id'], 'required'],
            [['name', 'available'], 'string', 'max' => 100],
            [['price'], 'number'],
            [['product_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'product_id' => 'Продукт',
            'price' => 'Цена',
            'available' => 'Наличие',
        ];
    }

    public function getCartId() {
        return $this->id;
    }
    
    public function getCartName() {
        return $this->product->name;
    }
    
    public function getCartPrice() {
        return $this->price;
    }

	public function getCartOptions()
	{
		return '';
	}
    
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    public static function editField($id, $name, $value) 
    {
        $setting = Price::findOne($id);
        $setting->$name = $value;
        $setting->save();
    }
}

<?php
namespace pistol88\shop\models;

use Yii;
use yii\helpers\Url;
use pistol88\shop\models\Category;
use pistol88\shop\models\Price;
use pistol88\shop\models\StockToProduct;
use pistol88\shop\models\product\ProductQuery;
use pistol88\shop\models\StockToUser;
use yii\db\ActiveQuery;

class Product extends \yii\db\ActiveRecord implements \pistol88\relations\interfaces\Torelate, \pistol88\cart\interfaces\CartElement
{
    function behaviors()
    {
        return [
            'images' => [
                'class' => 'pistol88\gallery\behaviors\AttachImages',
                'mode' => 'gallery',
            ],
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
            ],
            'relations' => [
                'class' => 'pistol88\relations\behaviors\AttachRelations',
                'relatedModel' => 'pistol88\shop\models\Product',
                'inAttribute' => 'related_ids',
            ],
            'toCategory' => [
                'class' => 'voskobovich\behaviors\ManyToManyBehavior',
                'relations' => [
                    'category_ids' => 'categories',
                ],
            ],
            'seo' => [
                'class' => 'pistol88\seo\behaviors\SeoFields',
            ],
            'filter' => [
                'class' => 'pistol88\filter\behaviors\AttachFilterValues',
            ],
            'field' => [
                'class' => 'pistol88\field\behaviors\AttachFields',
            ],
        ];
    }
    
    public static function tableName()
    {
        return '{{%shop_product}}';
    }
    
    public static function Find()
    {
        $return = new ProductQuery(get_called_class());
        $return = $return->with('category');
        
        return $return;
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['category_id', 'producer_id', 'sort'], 'integer'],
            [['text', 'available', 'code'], 'string'],
            [['category_ids'], 'each', 'rule' => ['integer']],
            [['name'], 'string', 'max' => 200],
            [['short_text', 'slug'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код (актикул)',
            'category_id' => 'Главная категория',
            'producer_id' => 'Бренд',
            'name' => 'Название',
            'amount' => 'Остаток',
            'text' => 'Текст',
            'short_text' => 'Короткий текст',
            'images' => 'Картинки',
            'available' => 'В наличии',
            'sort' => 'Сортировка',
            'slug' => 'СЕО-имя',
            'amount_in_stock' => 'Количество на складах',
        ];
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function minusAmount($count, $moderator="false")
    {
        if($moderator) {
            $user = yii::$app->user->getIdentity();
            if($stock = StockToUser::find()->where(['user_id' => $user->id])->one()->stock_id){
               $product = $this->minusAmountInStock($stock, $count);
            } else {
                $stock = Stock::find()->orderBy('id ASC')->one()->id;
                $product = $this->minusAmountInStock($stock, $count);
            }
        }
        return $product;
    }
    
    public function plusAmount($count, $moderator="false")
    {
        if($moderator) {
            $user = yii::$app->user->getIdentity();
            if($stock = StockToUser::find()->where(['user_id' => $user->id])->one()->stock_id){
               $product = $this->plusAmountInStock($stock, $count);
            } else {
                $stock = Stock::find()->orderBy('id ASC')->one()->id;
                $product = $this->plusAmountInStock($stock, $count);
            }
        }
		
        return $product->save(false);
    }
    
    public function setPrice($price, $type = 1)
    {
        if($priceModel = $this->getPriceModel()) {
            $priceModel->price = $price;
            return $priceModel->save(false);
        } else {
            $priceModel = new Price;
            $priceModel->product_id = $this->id;
            $priceModel->price = $price;
            $priceModel->type_id = $type;
            $priceModel->name = 'Основная цена';
            
            return $priceModel->save();
        }
        
        return false;
    }
    
    public function getPriceModel($type = 'lower')
    {
        $price = $this->hasOne(Price::className(), ['product_id' => 'id']);
        
        if($type == 'lower') {
            $price = $price->orderBy('price ASC')->one();
        } elseif($type) {
            $price = $price->where(['type_id' => $type])->one();
        } elseif($defaultType = yii::$app->getModule('shop')->getPriceTypeId($this)) {
            $price = $price->where(['type_id' => $defaultType])->one();
        } else {
            $price = $price->orderBy('price DESC')->one();
        }
        
        return $price;
    }
    
    public function getPrices()
    {
        $return = $this->hasMany(Price::className(), ['product_id' => 'id'])->orderBy('price ASC');

        return $return;
    }

    public function getPrice($type = 'lower')
    {
        if($price = $this->getPriceModel($type)) {
            return $price->price;
        }
        
        return null;
    }
    
    public function getProduct()
    {
        return $this;
    }
    
    public function getCartId() {
        return $this->id;
    }
    
    public function getCartName() {
        return $this->name;
    }
    
    public function getCartPrice() {
        return $this->price;
    }

    public function getCartOptions()
    {
        $options = [];
        
        if($filters = $this->getFilters()) {
            foreach($filters as $filter) {
                if($variants = $filter->variants) {
                    $options[$filter->id]['name'] = $filter->name;
                    foreach($variants as $variant) {
                        $options[$filter->id]['variants'][$variant->id] = $variant->value;
                    }
                }
            }
        }
        
        return $options;
        //return ['Цвет' => ['Красный', 'Белый', 'Синий'], 'Размер' => ['XXL']];
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getSellModel()
    {
        return $this;
    }

    public function getModifications()
    {
        $return = $this->hasMany(Modification::className(), ['product_id' => 'id'])->orderBy('sort DESC, id DESC');

        return $return;
    }

    public function getAmount()
    {   
        if($amount = StockToProduct::find()->where(['product_id' => $this->id])->sum('amount')){
            return StockToProduct::find()->where(['product_id' => $this->id])->sum('amount');
        } else {
            return 0;
        }
        
    }

    public function getLink()
    {
        return Url::toRoute([yii::$app->getModule('shop')->productUrlPrefix, 'slug' => $this->slug]);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
             ->viaTable('{{%shop_product_to_category}}', ['product_id' => 'id']);
    }
    
    public function getProducer()
    {
        return $this->hasOne(Producer::className(), ['id' => 'producer_id']);
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        
        Price::deleteAll(["product_id" => $this->id]);
        
        return false;
    }
    public function plusAmountInStock($stock, $count){
        if($profuctInStock = StockToProduct::find()->where(['product_id' => $this->id, 'stock_id' => $stock])->one()){
            $profuctInStock->amount = $profuctInStock->amount+$count;
            
        } else {
            $profuctInStock = new StockToProduct();
            $profuctInStock->amount = $count;
            $profuctInStock->stock_id = $stock;
            $profuctInStock->product_id = $this->id;
            
        }
        return $profuctInStock;
    }

    public function minusAmountInStock($stock, $count){
        if($profuctInStock = StockToProduct::find()->where(['product_id' => $this->id, 'stock_id' => $stock])->one()){
            if($profuctInStock->amount >= $count){
                $profuctInStock->amount = $profuctInStock->amount - $count;

            } else {
               return 'На складе всего '.$profuctInStock->amount.' единиц товара. Пытались снять '.$count; 
            }
        } else {
            return 'На складе нету такого товара. Пытались снять '.$count;
            
        }
        return $profuctInStock->save();
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if(!empty($this->category_id) && !empty($this->id)) {
            if(!(new \yii\db\Query())
            ->select('*')
            ->from('{{%shop_product_to_category}}')
            ->where('product_id ='.$this->id.' AND category_id = '.$this->category_id)
            ->all()) {
                yii::$app->db->createCommand()->insert('{{%shop_product_to_category}}', [
                    'product_id' => $this->id,
                    'category_id' => $this->category_id,
                ])->execute();
            }
        }
        
        return true;
    }
}

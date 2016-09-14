<?php
namespace pistol88\shop\models;

use Yii;
use yii\helpers\Url;
use pistol88\shop\models\Category;
use pistol88\shop\models\Price;
use pistol88\shop\models\product\ProductQuery;
use yii\db\ActiveQuery;

class Modification extends \yii\db\ActiveRecord implements \pistol88\cart\interfaces\CartElement
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
            'seo' => [
                'class' => 'pistol88\seo\behaviors\SeoFields',
            ],
            'time' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    public static function tableName()
    {
        return '{{%shop_product_modification}}';
    }
    
    public function rules()
    {
        return [
            [['name', 'product_id'], 'required'],
            [['sort', 'amount', 'product_id'], 'integer'],
            [['name', 'available', 'code', 'create_time', 'update_time', 'filter_values'], 'string'],
            [['name'], 'string', 'max' => 55],
            [['slug'], 'string', 'max' => 88]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'name' => 'Название',
            'code' => 'Код (актикул)',
            'images' => 'Картинки',
            'available' => 'В наличии',
            'sort' => 'Сортировка',
            'slug' => 'СЕО-имя',
            'amount' => 'Количество',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата обновления',
            'filter_values' => 'Сочетание значений фильтров',
        ];
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function minusAmount($count)
    {
        $this->amount = $this->amount-$count;
        
        return $this->save(false);
    }
    
    public function plusAmount($count)
    {
        $this->amount = $this->amount+$count;
        
        return $this->save(false);
    }
    
    public function getProduct()
    {
        return $this;
    }
    
    public function getCartId()
    {
        return $this->id;
    }
    
    public function getCartName()
    {
        return $this->name;
    }
    
    public function getCartPrice()
    {
        return $this->price;
    }

    public function getCartOptions()
    {
        return '';
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getSellModel()
    {
        return $this;
    }
    
    public function getPrices()
    {
        $return = $this->hasMany(Price::className(), ['product_id' => 'id'])->orderBy('price ASC');

        return $return;
    }
    
    public function getPrice($type = 'lower')
    {
        $price = $this->hasOne(Price::className(), ['product_id' => 'product_id']);
        
        if($type == 'lower') {
            $price = $price->orderBy('price ASC')->one();
        } elseif($type) {
            $price = $price->where(['type_id' => $type])->one();
        } elseif($defaultType = yii::$app->getModule('shop')->getPriceTypeId($this)) {
            $price = $price->where(['type_id' => $defaultType])->one();
        } else {
            $price = $price->orderBy('price DESC')->one();
        }
        
        if($price) {
            return $price->price;
        }
        
        return null;
    }
}

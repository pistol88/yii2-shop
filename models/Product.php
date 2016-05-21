<?php
namespace pistol88\shop\models;

use Yii;
use yii\helpers\Url;
use pistol88\shop\models\Category;
use pistol88\shop\models\Price;
use pistol88\shop\models\product\ProductQuery;
use yii\db\ActiveQuery;

class Product extends \yii\db\ActiveRecord implements \pistol88\relations\interfaces\Torelate
{
	function behaviors()
    {
        return [
            'images' => [
                'class' => 'pistol88\gallery\behaviors\AttachImages',
                'inAttribute' => 'images',
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
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getPrices()
    {
        $return = $this->hasMany(Price::className(), ['product_id' => 'id'])->orderBy('price ASC');

        return $return;
    }
    
    public function getPrice($type = 'lower')
    {
        $price = $this->hasOne(Price::className(), ['product_id' => 'id']);
        
        if($type == 'lower') {
            return $price->orderBy('price ASC');
        } else {
            return $price->orderBy('price DESC');
        }
    }
    
    public function getLink()
    {
        return Url::toRoute($this->category->slug.'/'.$this->slug);
    }

    public function rules()
    {
        return [
            [['category_id', 'name', 'text'], 'required'],
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
            'text' => 'Текст',
            'short_text' => 'Короткий текст',
            'images' => 'Картинки',
            'available' => 'В наличии',
            'sort' => 'Сортировка',
            'slug' => 'СЕО-имя',
        ];
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
        Price::deleteAll(["product_id" => $this->id]);
    }
}

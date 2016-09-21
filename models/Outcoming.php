<?php
namespace pistol88\shop\models;

use Yii;

class Outcoming extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%shop_outcoming}}';
    }

    public function rules()
    {
        return [
            [['content'], 'string'],
            [['date'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'content' => 'Содержание заказа',
        ];
    }
}

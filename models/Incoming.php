<?php
namespace pistol88\shop\models;

use Yii;

class Incoming extends \yii\db\ActiveRecord
{
	
    public static function tableName()
    {
        return '{{%shop_incoming}}';
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

<?php
namespace pistol88\shop\models\price;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\shop\models\PriceType;

class PriceTypeSearch extends PriceType
{
    public function rules()
    {
        return [
            [['id', 'sort'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PriceType::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

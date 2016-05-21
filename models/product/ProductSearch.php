<?php
namespace pistol88\shop\models\product;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\shop\models\Product;


class ProductSearch extends Product
{
    public function rules()
    {
        return [
            [['id', 'category_id', 'producer_id'], 'integer'],
            [['name', 'text', 'short_text', 'available'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => [
                    'name',
                    'id',
                    'available',
                ],
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'available' => $this->available,
			'producer_id' => $this->producer_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'short_text', $this->short_text])
			->andFilterWhere(['like', 'category_id', $this->category_id]);

        return $dataProvider;
    }
}

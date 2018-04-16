<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shop;

/**
 * ShopManageSearch represents the model behind the search form of `app\models\Shop`.
 */
class ShopManageSearch extends Shop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['shop_name', 'shop_description', 'shop_address'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);

        $query = Shop::find();

        $subQuery = BusinessHours::find()
            ->select('shop_id, count(weekday) as business_hours_count')
            ->groupBy('shop_id');
        $query->leftJoin(['business_hours_count' => $subQuery], 'business_hours_count.shop_id = id');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        $dataProvider->setSort([
            'attributes' => [
                'id',
                'shop_name',
                'shop_description',
                'shop_address',
                'business_hours' => [
                    'asc' => ['business_hours_count' =>SORT_ASC ],
                    'desc' => ['business_hours_count' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);


        //  filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ])->andFilterWhere(['like', 'shop_name', $this->shop_name])
          ->andFilterWhere(['like', 'shop_description', $this->shop_description])
          ->andFilterWhere(['like', 'shop_address', $this->shop_address]);


        return $dataProvider;
    }
}

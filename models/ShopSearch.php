<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shop;

/**
 * ShopSearch represents the model behind the search form of `app\models\Shop`.
 */
class ShopSearch extends Shop
{

    public $date_picker;
    public $time_picker;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['shop_name','date_picker','time_picker'], 'safe'],
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

        $query = Shop::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize=6;

        $this->load($params);

        $dayofweek = date('N', strtotime($this->date_picker));

        // join with related table `businessHours`
        $query->joinWith('businessHours');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ])->andFilterWhere(['like', 'shop_name', $this->shop_name])
            ->andFilterWhere(['=','business_hours.weekday',$dayofweek])
            ->andFilterWhere(['<=', 'business_hours.start_hour', $this->time_picker])
            ->andFilterWhere(['>=', 'business_hours.close_hour', $this->time_picker]);


        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersModelSearch represents the model behind the search form about `app\models\Orders`.
 */
class OrdersModelSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'payment_status', 'orders_to'], 'integer'],
            [['datetime_created', 'notes'], 'safe'],
            [['totals'], 'number'],
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
        $query = Orders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'datetime_created' => $this->datetime_created,
            'user_id' => $this->user_id,
            'totals' => $this->totals,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'orders_to' => $this->orders_to,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}

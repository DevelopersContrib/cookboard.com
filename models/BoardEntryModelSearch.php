<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BoardEntry;

/**
 * BoardEntryModelSearch represents the model behind the search form about `app\models\BoardEntry`.
 */
class BoardEntryModelSearch extends BoardEntry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'cuisine_id', 'course_id', 'diet_id', 'rating', 'delivery_type_id'], 'integer'],
            [['datetime_created', 'description', 'city'], 'safe'],
            [['price'], 'number'],
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
        $query = BoardEntry::find();

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
            'cuisine_id' => $this->cuisine_id,
            'course_id' => $this->course_id,
            'diet_id' => $this->diet_id,
            'rating' => $this->rating,
            'delivery_type_id' => $this->delivery_type_id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'city', $this->city]);

        return $dataProvider;
    }
}

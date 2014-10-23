<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CookBoardPin;

/**
 * CookBoardPinModelSearch represents the model behind the search form about `app\models\CookBoardPin`.
 */
class CookBoardPinModelSearch extends CookBoardPin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'cook_board_id', 'board_entry_id'], 'integer'],
            [['datetime_created'], 'safe'],
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
        $query = CookBoardPin::find();

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
            'cook_board_id' => $this->cook_board_id,
            'board_entry_id' => $this->board_entry_id,
        ]);

        return $dataProvider;
    }
}

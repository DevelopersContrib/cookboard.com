<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Messages;

/**
 * MessagesModelSearch represents the model behind the search form about `app\models\Messages`.
 */
class MessagesModelSearch extends Messages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_user_id', 'to_user_id', 'status'], 'integer'],
            [['to_all_user', 'subject', 'content', 'datetime_created'], 'safe'],
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
        $query = Messages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from_user_id' => $this->from_user_id,
            'to_user_id' => $this->to_user_id,
            'status' => $this->status,
            'datetime_created' => $this->datetime_created,
        ]);

        $query->andFilterWhere(['like', 'to_all_user', $this->to_all_user])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}

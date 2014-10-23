<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserModel;

/**
 * UserModelSearch represents the model behind the search form about `app\models\UserModel`.
 */
class UserModelSearch extends UserModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [['username', 'password', 'email', 'datetime_created', 'authKey', 'auth_key', 'notes'], 'safe'],
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
        $query = UserModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'datetime_created' => $this->datetime_created,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}

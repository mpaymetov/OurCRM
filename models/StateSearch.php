<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\State1;

/**
 * StateSearch represents the model behind the search form of `app\models\State`.
 */
class StateSearch extends State1
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_state'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = State::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_state' => $this->id_state,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function getStateList()
    {
        $state = (new \yii\db\Query())
            ->select('id_state, name')
            ->from('state')
            ->all();

        return ArrayHelper::map($state, 'id_state', 'name');
    }

    public function getLastStateId()
    {
        $state = (new \yii\db\Query())
            ->select('id_state')
            ->from('state')
            ->where('name=\'Закрыт\'');
        return ArrayHelper::map($state, 'id_state');
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Serviceset;

/**
 * ServicesetSearch represents the model behind the search form of `app\models\Serviceset`.
 */
class ServicesetSearch extends Serviceset
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_serviceset', 'id_project', 'id_state'], 'integer'],
            [['delivery', 'payment'], 'safe'],
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
        $query = Serviceset::find();

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
            'id_serviceset' => $this->id_serviceset,
            'id_project' => $this->id_project,
            'id_state' => $this->id_state,
            'delivery' => $this->delivery,
            'payment' => $this->payment,
        ]);

        return $dataProvider;
    }

    public function searchProjectId($id)
    {
        $query = Serviceset::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id_project' => $id,
        ]);
        return $dataProvider;
    }

    public function getServiceSetInfoByProjectId($id)
    {
        $provider = new SqlDataProvider([
            'sql' => 'SELECT [[serviceset.id_serviceset]] AS id, [[state.name]] AS state
            FROM {{serviceset}}
            LEFT JOIN {{state}} ON [[state.id_state]]=[[serviceset.id_state]]
            WHERE [[id_project]]=:id_project',
            'params' => [':id_project' => $id],
        ]);

        return $provider->getModels();
    }

}

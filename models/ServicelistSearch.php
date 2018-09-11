<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Servicelist;
use yii\data\SqlDataProvider;

/**
 * ServicelistSearch represents the model behind the search form of `app\models\Servicelist`.
 */
class ServicelistSearch extends Servicelist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicelist', 'id_serviceset', 'id_service'], 'integer'],
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
        $query = Servicelist::find();

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
            'id_servicelist' => $this->id_servicelist,
            'id_serviceset' => $this->id_serviceset,
            'id_service' => $this->id_service,
        ]);

        return $dataProvider;
    }

    public function getServiceSetInfo($id)
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(*) FROM {{servicelist}} WHERE [[id_serviceset]]=:id_serviceset',
            [':id_serviceset' => $id])->queryScalar();

        $provider = new SqlDataProvider([
            'sql' => 'SELECT [[service.name]] AS name, [[service.cost]] AS cost
            FROM {{servicelist}}
            LEFT JOIN {{service}} ON [[service.id_service]]=[[servicelist.id_service]]
            WHERE [[id_serviceset]]=:id_serviceset',
            'params' => [':id_serviceset' => $id],
        ]);

       return $provider->getModels();
    }

}

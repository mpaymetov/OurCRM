<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Client;

/**
 * ClientSearch represents the model behind the search form of `app\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_client', 'id_user'], 'integer'],
            [['name', 'created', 'comment'], 'safe'],
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
        $query = Client::find();

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
            'id_client' => $this->id_client,
            'created' => $this->created,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andWhere('client.id_user = ' . Yii::$app->user->identity->id_user);
        return $dataProvider;
    }

    public function searchClientId($id)
    {
        $query = Project::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id_client' => $id,
        ])
            ->andWhere('client.id_user = ' . Yii::$app->user->identity->id_user);;
        return $dataProvider;
    }


    public function searchClientList($idUser)
    {
        $query = Client::find()
            ->andFilterWhere([
                'id_user' => $idUser
            ])
            ->asArray()
            ->all();
        return $query;
    }
}

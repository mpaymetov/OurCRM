<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Event;

/**
 * EventSearch represents the model behind the search form of `app\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_event', 'link', 'id_link', 'id_user'], 'integer'],
            [['message', 'created', 'assignment'], 'safe'],
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
        $query = Event::find();

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
            'id_event' => $this->id_event,
            'created' => $this->created,
            'assignment' => $this->assignment,
            'link' => $this->link,
            'id_link' => $this->id_link,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
    public function searchEventId($id, $id_client)
    {
        $query = Event::find();
        // add conditions that should always apply here
        $eventDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id_user' => $id,
        ]);
        return $eventDataProvider;
    }
}

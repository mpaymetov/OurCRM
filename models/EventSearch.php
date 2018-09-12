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
            [['id_event', 'link', 'id_link', 'id_user', 'is_active'], 'integer'],
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
    public function search($params, $location = null)
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
            'is_active' => $this->is_active,
        ]);
        print_r($location);

        if ($location == 'index') {
            $query->andFilterWhere(['like', 'message', $this->message])
                ->andWhere('event.id_user = ' . Yii::$app->user->identity->id_user)
                ->andWhere('event.is_active != 0');
        } else {
            $query->andFilterWhere(['like', 'message', $this->message])
                ->andWhere('event.id_user = ' . Yii::$app->user->identity->id_user);
        }

        return $dataProvider;
    }

    public function searchEventOnIndex()
    {

    }

    public function searchEventId($id_link, $id_user, $route_link)
    {
        if (!Yii::$app->user->isGuest) {
            $query = Event::find();
            $eventDataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $query->select(['*'])
                ->from('event')
                ->where(['link' => $route_link])
                ->andwhere(['id_link' => $id_link])
                ->andwhere(['id_user' => $id_user])
                ->all();

            return $eventDataProvider;
        }
    }

    public function searchClientEventId($id_client)
    {
        if (!Yii::$app->user->isGuest) {
            $query = Event::find();
            $eventDataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $query->select(['*'])
                ->from('event')
                ->leftJoin('project', 'event.id_link = project.id_project')
                ->where(['or', ['and', ['event.link' => 2, 'project.id_client' => $id_client]], ['and', ['event.link' => 1, 'event.id_link' => $id_client]]])
                ->all();

            return $eventDataProvider;
        }
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Project;
use app\models\Client;

/**
 * ProjectSearch represents the model behind the search form of `app\models\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_project', 'id_client', 'id_user', 'is_active'], 'integer'],
            [['name', 'comment',  'client'], 'safe'],
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
        $query = Project::find();
        $query->joinWith('client');

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
            'id_project' => $this->id_project,
            'id_client' => $this->id_client,
            'id_user' => $this->id_user,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andWhere('project.id_user = ' . Yii::$app->user->identity->id_user)
            ->andFilterWhere(['like', 'client.name', $this->client])
            ->asArray()
            ->all();


        return $dataProvider;
    }

    public function searchClientProject($id)
    {
        $query = Project::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id_client' => $id,
        ]);
        return $dataProvider;
    }

    public function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function findProjectInfo($id)
    {
        $model = $this->findModel($id);
        $client = Client::findOne($model->id_client);
        $model->id_client = $client->name;
        return $model;

    }

    public function searchNotDoneProject($params, $location = null)
    {
        $query = Project::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            // uncomment the following line if you do not want to return any records when validation fails

            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_project' => $this->id_project,
            'id_client' => $this->id_client,
            'id_user' => $this->id_user,
            'is_active' => $this->is_active,
        ]);

        if ($location == 'index') {
            $date = date('Y-m-d'); // сверяем только по суткам, после 12 не закрытые события переходят в незавершенные
            $query->andFilterWhere(['like', 'comment', $this->comment])
                ->andWhere('project.id_user = ' . Yii::$app->user->identity->id_user)
                ->andWhere('project.is_active != 0');
        } else {
            $query->andFilterWhere(['like', 'message', $this->message])
                ->andWhere('project.id_user = ' . Yii::$app->user->identity->id_user);
        }
        return $dataProvider;
    }
}

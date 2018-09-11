<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
$route_link = 2;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <div class="col-md-6">
        <div class="project-view">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id_project], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id_project], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_project',
                    'name',
                    'id_client',
                    'id_user',
                    'comment:ntext',
                    'is_active',
                ],
            ]) ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="event-index">
            <?php
            /* @var $this yii\web\View */
            /* @var $searchEventModel app\models\EventSearch */
            /* @var $eventDataProvider yii\data\ActiveDataProvider */
            ?>
            <h1><?= Html::encode($this->title) ?>'s Events</h1>
            <p>

                <a href='<?= Url::to(['event/create', 'id_user' => Yii::$app->user->identity->getId(), 'id_link' => $model -> id_project, 'link' => $route_link]) ?>' class="btn btn-success">
                    <?= \Yii::t('common', 'Create Event') ?></a>
            </p>
            <div class="client-index">
                <?= ListView::widget([
                    'dataProvider' => $eventDataProvider,
                    'itemView' => '../event/_event_id',
                ]) ?>
            </div>
        </div>

        <div class="serviceset-index">

            <?php
            $this->title = Yii::t('common', 'Servicesets');
            ?>

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <a href='<?= Url::to(['serviceset/create', 'id_project' => $model->id_project]) ?>' class="btn btn-success">
                    <?= \Yii::t('common', 'Create Serviceset') ?></a>
            </p>

        </div>
    </div>

    <div class="col-md-12">
        <div class="servicelist-index">
            <?php
            for ($i = 0; $i < count($serviceListDataProvider); $i++)
            {
                $serviceSetInfo = $serviceListDataProvider[$i]['ServiceSetInfo'];
                $serviceListInfo = $serviceListDataProvider[$i]['ServiceListInfo'];
                echo ListView::widget([
                    'dataProvider' => $serviceSetInfo,
                    'itemView' => '_servicelist-view',
                    'layout' => "{items}"
                ]);
                echo GridView::widget([
                    'dataProvider' => $serviceListInfo,
                    'layout' => "{items}"
                ]);
            }
            ?>
        </div>
    </div>
</div>






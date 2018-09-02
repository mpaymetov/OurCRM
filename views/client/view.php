<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
$route_link = 1;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id_client], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id_client], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_client',
            'name',
            'created',
            'comment:ntext',
            'id_user',
        ],
    ]) ?>

</div>


<div class="col-md-6">
    <div class="project-index">
        <h1><?= Html::encode($this->title) ?>'s projects</h1>
        <p>
            <a href='<?= Url::to(['project/create', 'id_client' => $model->id_client, 'id_user' => Yii::$app->user->identity->getId()]) ?>'
               class="btn btn-success">
                <?= \Yii::t('common', 'Create Project') ?></a>
        </p>
        <?php
        /* @var $this yii\web\View */
        /* @var $searchProjectModel app\models\EventSearch */
        /* @var $dataProvider ; yii\data\ActiveDataProvider */
        ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '../project/_project_id',
        ]) ?>
    </div>
</div>
<div class="col-md-6">
    <div class="event-index">
        <?php
        /* @var $this yii\web\View */
        /* @var $searchClientEventModel app\models\EventSearch */
        /* @var $clientEventDataProvider yii\data\ActiveDataProvider */
        ?>
        <h1><?= Html::encode($this->title) ?>'s Events</h1>
        <p>

            <a href='<?= Url::to(['event/create', 'id_user' =>Yii::$app->user->identity->getId(), 'id_link' => $model -> id_client, 'link' => $route_link]) ?>' class="btn btn-success">
                <?= \Yii::t('common', 'Create Event') ?></a>
        </p>
        <div class="client-index">
            <?= ListView::widget([
                'dataProvider' => $clientEventDataProvider,
                'itemView' => '../event/_event_id',
            ]) ?>
        </div>
    </div>
</div>
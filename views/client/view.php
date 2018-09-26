<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
$route_link = 1;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">


    <div class="post panel">
        <div class="panel-body">
            <h4><?= html::encode($model->name)?></h4>
            <p class="post_number"><?= \Yii::t('common', 'client number: ')?> <?= HtmlPurifier::process($model->id_client) ?></p>
            <p><?= html::encode($model->comment)?></p>
            <p class=" btn btn_more">
                <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id_client], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id_client], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>


<div class="col-md-6">
    <div class="project-index">
        <h1><?= Yii::t('common', 'Projects for client: ')?><?= Html::encode($this->title) ?></h1>
        <p>
            <a href='<?= Url::to(['project/create', 'id_client' => $model->id_client, 'id_user' => Yii::$app->user->identity->getId()]) ?>'
               class="btn btn-success">
                <?= \Yii::t('common', 'Create Project') ?></a>
        </p>
        <?php
        /* @var $this yii\web\View */
        /* @var $searchProjectModel app\models\ProjectSearch */
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
        <h1><?= Yii::t('common', 'Events for client: ')?><?= Html::encode($this->title) ?></h1>
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
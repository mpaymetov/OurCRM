<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_project',
            'name',
            'id_client',
            'id_manager',
            'comment:ntext',
            //'is_active',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<div class="col">
    <?php
    /* @var $this yii\web\View */
    /* @var $searchModel app\models\ProjectSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    ?>
    <h1>Events</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <a href='<?= Url::toRoute('/project/create'); ?>' class="btn btn-success">Create Event</a>
    </p>


</div>

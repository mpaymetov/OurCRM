<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?= $this->title = 'OurCrm'; ?>
<div class="client-index">
    <div class="row">
        <div class="col">
            <?php
            /* @var $this yii\web\View */
            /* @var $searchModel app\models\ManagerSearch */
            /* @var $dataProvider yii\data\ActiveDataProvider */
            ?>

            <h1>Managers</h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <p>
                <a href='<?= Url::toRoute('/manager/create'); ?>' class="btn btn-success">Create manager</a>
            </p>

            <?= ListView::widget([
                'dataProvider' => $managerDataProvider,
                'itemView' => '_post_manager',
            ]) ?>
        </div>
        <div class="col">
            <h1>Clients</h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <a href='<?= Url::toRoute('/client/create'); ?>' class="btn btn-success">Create client</a>
            </p>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_post_client',
            ]) ?>
        </div>
        <div class="col">
            <?php
            /* @var $this yii\web\View */
            /* @var $searchModel app\models\ProjectSearchSearch */
            /* @var $dataProvider yii\data\ActiveDataProvider */


            ?>

            <h1>Projects</h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <a href='<?= Url::toRoute('/project/create'); ?>' class="btn btn-success">Create project</a>
            </p>


            <?= ListView::widget([
                'dataProvider' => $projectDataProvider,
                'itemView' => '_post_project',
            ]) ?>
        </div>
        <div class="col">
            <?php
            /* @var $this yii\web\View */
            /* @var $searchModel app\models\EventSearch */
            /* @var $dataProvider yii\data\ActiveDataProvider */

            ?>
            <h1>Events</h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <p>
                <a href='<?= Url::toRoute('/event/create'); ?>' class="btn btn-success">Create Event</a>
            </p>

            <?= ListView::widget([
                'dataProvider' => $eventDataProvider,
                'itemView' => '_post_event',
            ]) ?>

        </div>
    </div>
</div>
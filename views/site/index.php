<?php

use yii\widgets\ListView;
use yii\helpers\Url;

if ( Yii::$app->user->isGuest )
    return Yii::$app->getResponse()->redirect(array('/site/login',302));

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

            <h1><?= \Yii::t('common', 'Users')?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <p>
                <a href='<?= Url::toRoute('/user/create'); ?>' class="btn btn-success"><?= \Yii::t('common', 'Create user')?></a>
            </p>

            <?= ListView::widget([
                'dataProvider' => $userDataProvider,
                'itemView' => '_post_user',
            ]) ?>
        </div>
        <div class="col">
            <h1><?= \Yii::t('common', 'Clients')?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <a href='<?= Url::toRoute('/client/create'); ?>' class="btn btn-success"><?= \Yii::t('common', 'Create Client')?></a>
            </p>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_post_client',
            ]) ?>
        </div>
        <div class="col">
            <?php
            /* @var $this yii\web\View */
            /* @var $searchModel app\models\ProjectSearch */
            /* @var $dataProvider yii\data\ActiveDataProvider */


            ?>

            <h1><?= \Yii::t('common', 'Projects')?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <a href='<?= Url::toRoute('/project/create'); ?>' class="btn btn-success"><?= \Yii::t('common', 'Create Project')?></a>
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
            <h1><?= \Yii::t('common', 'Events')?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <p>
                <a href='<?= Url::toRoute('/event/create'); ?>' class="btn btn-success"><?= \Yii::t('common', 'Create Event')?></a>
            </p>

            <?= ListView::widget([
                'dataProvider' => $eventDataProvider,
                'itemView' => '_post_event',
            ]) ?>

        </div>
    </div>
</div>
<?php

use yii\widgets\ListView;
use yii\helpers\Url;

if ( Yii::$app->user->isGuest )
    return Yii::$app->getResponse()->redirect(array('/site/login',302));

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="client-index">
    <div class="row">
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
        </div>
    </div>
</div>
<?php
/* @var $this yii\web\View */
use yii\widgets\ListView;
use yii\helpers\Url;
?>
<div class="col">
    <?php
    /* @var $this yii\web\View */
    /* @var $searchModel app\models\EventSearch */
    /* @var $eventDataProvider yii\data\ActiveDataProvider */
    /* @var $searchModel app\models\projectSearch */
    /* @var $projectDataProvider yii\data\ActiveDataProvider */

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
<div class="col">
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
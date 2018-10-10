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
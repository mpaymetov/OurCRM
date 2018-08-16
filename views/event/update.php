<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = Yii::t('app', 'Update Event: ' . $model->id_event, [
    'nameAttribute' => '' . $model->id_event,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_event, 'url' => ['view', 'id' => $model->id_event]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

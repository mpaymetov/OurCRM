<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = Yii::t('common', 'Update Client: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_client]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="client-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

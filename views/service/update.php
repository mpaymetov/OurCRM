<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = \Yii::t('common', 'Update Service: '). $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_service]];
$this->params['breadcrumbs'][] = \Yii::t('common', 'Update');
echo Html::activeHiddenInput($model, 'version');
?>
<div class="service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Servicelist */

$this->title = Yii::t('app', 'Update Servicelist: ' . $model->id_servicelist, [
    'nameAttribute' => '' . $model->id_servicelist,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servicelists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_servicelist, 'url' => ['view', 'id' => $model->id_servicelist]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
echo Html::activeHiddenInput($model, 'version');
?>
<div class="servicelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Serviceset */

$this->title = 'Update Serviceset: ' . $model->id_serviceset;
$this->params['breadcrumbs'][] = ['label' => 'Servicesets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_serviceset, 'url' => ['view', 'id' => $model->id_serviceset]];
$this->params['breadcrumbs'][] = 'Update';
$idServiceSet = $model->id_serviceset;
echo Html::activeHiddenInput($model, 'version');
?>
<div class="serviceset-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'itemsState' => $itemsState,
    ]) ?>

    <div class="servicelist-create">

        <?= $this->render('_formServiceLIst',[
            'modelForm' => $modelForm,
            'itemsService' => $itemsService,
            'idServiceSet' => $idServiceSet,
        ]) ?>


    </div>

</div>

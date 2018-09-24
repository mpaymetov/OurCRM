<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Serviceset */

$this->title = Yii::t('common', 'Create Serviceset');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Servicesets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formServiceLIst',[
        'modelForm' => $modelForm,
        'itemsService' => $itemsService,
    ]) ?>


</div>

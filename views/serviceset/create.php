<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Serviceset */

$this->title = 'Create Serviceset';
$this->params['breadcrumbs'][] = ['label' => 'Servicesets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serviceset-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Servicelist */

$this->title = Yii::t('app', 'Create Servicelist');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servicelists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StateCheck */

$this->title = \Yii::t('common', 'Create State');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', \Yii::t('common', 'States')), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

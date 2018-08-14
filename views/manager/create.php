<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Manager */

$this->title = \Yii::t('common', 'Create Manager');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'Managers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-create">
    <div class="panel">
        <div class="panel-body">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

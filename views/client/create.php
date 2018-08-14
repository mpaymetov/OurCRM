<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = \Yii::t('common', 'Create Client');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">
    <div class="panel">
        <div class="panel-body">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

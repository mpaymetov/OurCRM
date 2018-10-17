<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StateCheck */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('common', 'Update'), ['update', 'id' => $model->id_state], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('common', 'Delete'), ['delete', 'id' => $model->id_state], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_state',
            'name',
        ],
    ]) ?>

</div>

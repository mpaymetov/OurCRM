<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Events')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">
    <div class="post panel">
        <div class="panel-body">
            <p class="post_number"><?= \Yii::t('common', 'event number: ')?> <?= HtmlPurifier::process($model->id_event) ?></p>
            <h4><?= html::encode($model->message)?></h4>
        <p><?= \Yii::t('common', 'created: ')?><?= html::encode($model->created)?></p>
        <p><?= \Yii::t('common', 'assignment: ')?><?= html::encode($model->assignment)?></p>
            <p class=" btn btn_more">
                <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id_event], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id_event], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>

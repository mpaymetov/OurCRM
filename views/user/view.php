<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_user], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Disable'), ['disable', 'id' => $model->id_user], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to disable this item?'),
                    'method' => 'post',
                ],
            ])
        ?>
        <?= Html::a(Yii::t('app', 'Enable'), ['enable', 'id' => $model->id_user], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'first_name',
            'second_name',
            'email:email',
            'departments.name',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('common', 'Reset Password'), ['reset', 'id' => $model->id_user], ['class' => 'btn btn-primary']) ?>
    </p>

</div>

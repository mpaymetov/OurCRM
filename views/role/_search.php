<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RoleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_role') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'is_admin') ?>

    <?= $form->field($model, 'user_read_all') ?>

    <?= $form->field($model, 'user_self_dep') ?>

    <?php // echo $form->field($model, 'user_create') ?>

    <?php // echo $form->field($model, 'client_read_all') ?>

    <?php // echo $form->field($model, 'client_create') ?>

    <?php // echo $form->field($model, 'project_read_all') ?>

    <?php // echo $form->field($model, 'project_create') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

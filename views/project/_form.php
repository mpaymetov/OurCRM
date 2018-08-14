<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    if ($model->id_client) {
        echo $form->field($model, 'id_client')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
        echo $form->field($model, 'id_client')->textInput(['maxlength' => true]);
    }
    ?>

    <?= $form->field($model, 'id_manager')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <a href='<? Url::toRoute(['serviceset/view'])?>' class="btn-success btn">Add Service set</a>

</div>

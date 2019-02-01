<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?php
    echo $form->field($model, 'is_active')->checkbox([ 'checked ' => true]);
    ?>

    <div class="form-group">
        <?= Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
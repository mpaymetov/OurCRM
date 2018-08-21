<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Servicelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_serviceset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_service')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

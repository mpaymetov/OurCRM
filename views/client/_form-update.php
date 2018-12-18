<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.12.2018
 * Time: 16:39
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>


    <?= Html::activeHiddenInput($model, 'version'); ?>

    <div class="form-group">
        <?= Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\State;
use app\models\StateSearch;

$state = (new \yii\db\Query())
->select('id_state, name')
->from('state')
->all();

$itemsState = ArrayHelper::map($state, 'id_state', 'name');


/* @var $this yii\web\View */
/* @var $model app\models\Serviceset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serviceset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if($model->id_project) {
       echo $form->field($model, 'id_project')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
       echo $form->field($model, 'id_project')->textInput(['maxlength' => true]);
    }
    ?>

    <?= $form->field($model, 'id_state')->dropDownList($itemsState)?>

    <?= $form->field($model, 'delivery')->textInput() ?>

    <?= $form->field($model, 'payment')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

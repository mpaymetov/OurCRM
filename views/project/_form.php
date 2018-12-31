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

    <?php
        if($model->id_client == null)
        {
            echo $form->field($model, 'id_client')->dropDownList($clientList, ['prompt' => 'Выберите организацию']);
        }
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?php
    echo $form->field($model, 'is_active')->checkbox([ 'checked ' => true]);
    ?>

    <?= $form->field($modelForm, 'serviceList')-> widget(MultipleInput::className(), [
        'max' => 12,
        'min' => 1,
        'columns' => [
            [
                'name' => 'Service',
                'type'  => 'dropDownList',
                'items' => $itemsService,
            ]
        ]
    ])?>

    <div class="form-group">
        <?= Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
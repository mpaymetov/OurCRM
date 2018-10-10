<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DatePicker;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created')->textInput([
        'value' => date('Y/m/d H:i:s', time()),
    ]) ?>

    <?php echo '<div class="form-group"> <label class = "control-label">Создавший</label>
                <div class = "form-control ">' . (User::findNameById($model->id_user)). '</div> </div>' ?>

    <?= $form->field($model, 'id_doer')->textInput(['maxlength' => true]) ?>

    <?php
    if ($model->version == 0) {
        echo $form->field($model, 'assignment')->textInput(['value' => date('Y/m/d H:i:s', time()),
        ]);
    } else {
        echo $form->field($model, 'assignment')->textInput(['value' => $model->assignment]);
    } ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>


    <?php
    echo $form->field($model, 'is_active')->checkbox();
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

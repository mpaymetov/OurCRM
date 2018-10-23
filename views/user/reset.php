<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('common', 'Reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-reset">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= \Yii::t('common', 'Please fill out the following fields to signup: ') ?></p>

    <?php $form = ActiveForm::begin([
        'id' => 'form-reset',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton(\Yii::t('common', 'Reset'), ['class' => 'btn btn-primary', 'name' => 'reset-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
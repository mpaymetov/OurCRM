<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.08.2018
 * Time: 19:33
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $modelServicelist app\models\Servicelist */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="servicelist-form">


    <?php $form = ActiveForm::begin([]); ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>
    <?= Html::activeHiddenInput($model, 'id_project'); ?>

    <?= $form->field($model, 'id_state')->dropDownList($itemsState) ?>
    <?=  $form->field($model, 'delivery')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]);
    ?>
    <?=  $form->field($model, 'payment')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]);
    ?>

    <?= $form->field($modelForm, 'serviceList')-> widget(MultipleInput::className(), [
        'max' => 12,
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
        <?= Html::submitButton(Yii::t('app', Yii::t('common', 'Save')), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

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

/* @var $this yii\web\View */
/* @var $modelServicelist app\models\Servicelist */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="servicelist-form">


    <?php $form = ActiveForm::begin([]); ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>
    <?= Html::activeHiddenInput($model, 'id_project'); ?>

    <?php
   /* if ($model->id_project) {
        echo $form->field($model, 'id_project')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
        echo $form->field($model, 'id_project')->textInput(['maxlength' => true]);
    }*/
    ?>

    <?= $form->field($model, 'id_state')->dropDownList($itemsState) ?>

    <?= $form->field($model, 'delivery')->widget(\kartik\datetime\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'payment')->widget(\kartik\datetime\DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?php
    /*for($i = 0; $i < count($info); $i++)
    {
        $num = $info[$i];
        echo $form->field($modelForm, 'serviceList')->dropDownList(
            $itemsService,
            ['options' => [
                $num => ['Selected' => true],
                ],
            ]);
    }*/
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

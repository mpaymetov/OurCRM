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

    <?php
    var_dump($data);
    ?>

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($modelServicelist, 'serviceList')-> widget(MultipleInput::className(), [
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
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

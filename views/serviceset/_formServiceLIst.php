<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.08.2018
 * Time: 19:33
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelServicelist app\models\Servicelist */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="servicelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelServicelist, 'id_serviceset')->textInput(['value' => $idServiceSet, 'readonly' => true]) ?>

    <?= $form->field($modelServicelist, 'id_service')->dropDownList($itemsService)?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

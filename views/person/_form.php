<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.12.2018
 * Time: 16:56
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="person-form">

<?php $form = ActiveForm::begin();
    echo $form->field($model, 'main')->checkbox();
    echo $form->field($model, 'first_name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'last_name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'position')->textInput(['maxlength' => true]);
    echo $form->field($model, 'contact')->textInput(['maxlength' => true]);
    echo $form->field($model, 'email')->textInput(['maxlength' => true]);
    echo Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']);
    echo Html::submitButton(\Yii::t('common', 'Save'), ['class' => 'btn btn-primary']);

    ActiveForm::end(); ?>

</div>
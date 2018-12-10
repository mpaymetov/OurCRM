<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.12.2018
 * Time: 19:15
 */
 use yii\helpers\Html;

 echo Html::beginTag('div', ['class' => 'person']);
    echo Html::tag('h3', \Yii::t('common', 'Create new contact person'), []);
    echo $this->render('_form', [
        'model' => $model
    ]);
 echo Html::endTag('div');
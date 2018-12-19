<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.12.2018
 * Time: 18:46
 */
use yii\helpers\Html;

echo Html::beginTag('div', ['class' => 'one-person panel']);

    echo Html::beginTag('div');
        echo Html::label(\Yii::t('common', 'Main'));
        echo Html::checkbox ( 'main', $checked = $person['main'], $options = [] );
    echo Html::endTag('div');


    if($person['first_name'] != null) {
        $content = \Yii::t('common', 'First Name') . ': ' . html::encode($person['first_name']);
        echo Html::tag('p', $content);
    }

    if($person['last_name'] != null) {
        $content = \Yii::t('common', 'Last Name') . ': ' . html::encode($person['last_name']);
        echo Html::tag('p', $content);
    }

    if($person['position'] != null) {
        $content = \Yii::t('common', 'Position') . ': ' . html::encode($person['position']);
        echo Html::tag('p', $content);
    }

    $content = \Yii::t('common', 'Contact') . ': ' . html::encode($person['contact']);
    echo Html::tag('p', $content);

    if($person['email'] != null) {
        $content = 'E-mail' . ': ' . html::encode($person['email']);
        echo Html::tag('p', $content);
    }

    if($person['main'] != true) {
        echo Html::a(Yii::t('common', 'Delete'), ['person/delete', 'id' => $person['id_person']], ['class' => 'btn btn-danger', 'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post']]);
    }

echo Html::endTag('div');

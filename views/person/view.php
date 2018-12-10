<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.12.2018
 * Time: 16:44
 */
use yii\helpers\Html;

echo Html::tag('h3', 'Контакты организации' , []);

foreach ($model as $person) {
    echo $this->render('viewOne', [
        'person' => $person
    ]);
}

echo Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']);

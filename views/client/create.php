<?php

use yii\helpers\Html;

if ( Yii::$app->user->isGuest )
    return Yii::$app->getResponse()->redirect(array('/site/login',302));

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = Yii::t('common', 'Create Client');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->id_user = Yii::$app->user->identity->id_user;
?>
<div class="client-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPerson' => $modelPerson
    ]) ?>
    <?= Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']) ?>
</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = Yii::t('common', 'Create Event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$request = Yii::$app->request;
$request = Yii::$app->request;
$user_id = Yii::$app->user->identity->id_user;
$link_id = $request->get('id_link');
$user_id = $request->get('id_user');
$link = $request->get('link');
$model->link = $link;
$model->id_link = $link_id;
$model->id_user = $user_id;
?>
<div class="event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = Yii::t('common', 'Create Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$request = Yii::$app->request;
$client_id = $request->get('id_client');
$user_id = Yii::$app->user->identity->id_user;
$model->id_client = $client_id;
$model->id_user = $user_id;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

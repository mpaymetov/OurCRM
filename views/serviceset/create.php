<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Serviceset */

$this->title = 'Create Serviceset';
$this->params['breadcrumbs'][] = ['label' => 'Servicesets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$request = Yii::$app->request;
$project_id = $request->get('id_project');
$model->id_project = $project_id;
?>
<div class="serviceset-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

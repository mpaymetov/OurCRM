<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = Yii::t('common', 'Update Project: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_project]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
echo Html::activeHiddenInput($model, 'version');
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

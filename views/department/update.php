<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Department */

$this->title = Yii::t('common', 'Update Department: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('common', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_department]];
$this->params['breadcrumbs'][] = \Yii::t('common', 'Update');
echo Html::activeHiddenInput($model, 'version');
?>
<div class="department-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

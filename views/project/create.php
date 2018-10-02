<?php

use yii\helpers\Html;
use yii\web\Request;


/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = Yii::t('common', 'Create Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

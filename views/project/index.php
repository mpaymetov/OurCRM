<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\service\ProjectService;
/* @var $this yii\web\View */
/* @var $searchModel app\service\ProjectService */
/* @var $dataProvider app\service\ProjectService */

$this->title = Yii::t('common', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_project',
            'name',
            'id_client',
            'comment:ntext',
            //'is_active',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

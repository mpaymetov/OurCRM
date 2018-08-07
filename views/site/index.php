<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use app\models\Client;
use app\controllers\ClientController;
use app\models\ClientSearch;
use yii\web\Controller;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
?>
<div class="client-index">
        <div class="row">
            <div class="col">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <a href='<?= Url::toRoute('/client/index');?>' class="btn btn-success" >Create client</a>
    </p>

    <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post_client',
    ]) ?>
</div>
        <div class="col">
<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= ListView::widget([
        'dataProvider' => $projectDataProvider,
        'itemView' => '_post_project',
    ]) ?>


</div>
        </div>
        <div class="col">
<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\ManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Managers';
?>
<div class="manager-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Manager', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $managerDataProvider,
        'itemView' => '_post_manager',
    ]) ?>

</div>
        </div>
        </div>
        </div>
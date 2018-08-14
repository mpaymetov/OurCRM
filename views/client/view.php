<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $model app\models\Project */
/* @var $model app\models\Event */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_client], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_client], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_client',
            'name',
            'created',
            'comment:ntext',
            'id_manager',
        ],
    ]) ?>

</div>

<?php

?>
<div class="col-md-6">
    <div class="project-index">

        <h1><?= Html::encode($this->title) ?>'s projects</h1>

        <p>
            <a href='<?= Url::to(['project/create', 'id' => $model->id_client]) ?>' class="btn btn-success">Create
                Project</a>
        </p>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '../project/_project_id',
        ]) ?>
    </div>
</div>
<div class="col-md-6">
    <div class="event-index">
        <?php
        /* @var $this yii\web\View */
        /* @var $searchModel app\models\EventSearch */
        /* @var $dataProvider yii\data\ActiveDataProvider */
        ?>
        <h1><?= Html::encode($this->title) ?>'s Events</h1>

        <p>
            <a href='<?= Url::to(['event/create', 'id' => $model->id_client]) ?>' class="btn btn-success">Create
                Event</a>
        </p>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '../event/_event_id',
        ]) ?>
    </div>
</div>
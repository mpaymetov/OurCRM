<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">
<?php /*
   <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common', 'Create Event'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_event',
            'message',
            'created',
            'assignment',
            'link',
            //'id_link',
            //'id_user',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?> */?>
    <div id="container"></div>
    <script src="js/bundle.js"></script>
</div>

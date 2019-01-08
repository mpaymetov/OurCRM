<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServicesetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Сделки');
?>

<?php /*
<p>
    <a href='<?= Url::toRoute('/deal/create'); ?>' class="btn btn-success"><?= \Yii::t('common', 'Создать сделку')?></a>
</p>

<div class="serviceset-index col-md-12">
    <?php
    //var_dump($dataProvider);
    foreach($dataProvider as $item) {
        echo Html::beginTag('div', ['class'=>'col-md-2']);
        echo Html::tag('h4', $item['state']);
        echo ListView::widget([
            'dataProvider' => $item['info'],
            'itemView' => '_info',
            'layout' => "{items}"
        ]);
        echo Html::endTag('div');
    }
    ?>

    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_serviceset',
            'id_project',
            'id_state',
            'delivery',
            'payment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>

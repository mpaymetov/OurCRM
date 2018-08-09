<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;


?>
<div class="post panel">
    <div class="panel-body">
        <p class="post_number">Event number: <?= HtmlPurifier::process($model->id_event) ?></p>
        <h4><?= Html::encode($model->message) ?></h4>
        <a href=<?= Url::toRoute(['event/view', 'id' => $model->id_event]) ?> class="btn btn_more">view more</a>
    </div>
</div>
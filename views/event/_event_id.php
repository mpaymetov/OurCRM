<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>
<div class="col-md-6">
    <div class="post panel">
        <div class="panel-body">
            <p class="post_number">event number: <?= HtmlPurifier::process($model->id_event) ?></p>
            <h3><?= Html::encode($model->message) ?></h3>
            <p><?= html::encode($model->created) ?></p>
            <a href='<?= Url::to(['event/view', 'id' => $model->id_event]) ?>' class="btn btn_more">view more</a>
        </div>
    </div>
</div>


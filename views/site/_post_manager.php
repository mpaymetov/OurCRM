<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;


?>
<div class="post panel">
    <div class="panel-body">
        <p class="post_number">Manager number: <?= HtmlPurifier::process($model->id_manager) ?></p>
        <h4><?= Html::encode($model->name) ?></h4>
        <a href=<?= Url::toRoute('manager/more') ?> class="btn btn_more">view more</a>
    </div>
</div>
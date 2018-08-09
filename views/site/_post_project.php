<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

?>
<div class="post panel">
    <div class="panel-body">
        <h2><?= Html::encode($model->name) ?></h2>
        <?= HtmlPurifier::process($model->id_project) ?>
        <a href='<?= Url::to(['project/view', 'id' => $model->id_project]) ?>' class="btn btn_more">view more</a>
    </div>
</div>


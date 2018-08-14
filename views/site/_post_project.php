<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

?>
<div class="post panel">
    <div class="panel-body">
        <p class="post_number"><?= \Yii::t('common', 'project number: ')?> <?= HtmlPurifier::process($model->id_project) ?></p>
        <h2><?= Html::encode($model->name) ?></h2>
        <p><?= html::encode($model->comment)?></p>
        <a href='<?= Url::to(['project/view', 'id' => $model->id_project]) ?>' class="btn btn_more"><?= \Yii::t('common', 'view more')?></a>
    </div>
</div>


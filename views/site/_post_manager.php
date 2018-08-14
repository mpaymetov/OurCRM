<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;


?>
<div class="post panel">
    <div class="panel-body">
        <p class="post_number"><?= \Yii::t('common', 'manager number: ')?> <?= HtmlPurifier::process($model->id_manager) ?></p>
        <h4><?= Html::encode($model->name) ?></h4>
        <a href=<?= Url::toRoute(['manager/view', 'id' => $model->id_manager]) ?> class="btn btn_more"><?= \Yii::t('common', 'view more')?></a>
    </div>
</div>
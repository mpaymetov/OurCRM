<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;


?>
<div class="post panel">
    <div class="panel-body">
        <p class="post_number"><?= \Yii::t('common', 'user number: ')?> <?= HtmlPurifier::process($model->id) ?></p>
        <h4><?= Html::encode($model->login) ?></h4>
        <a href=<?= Url::toRoute(['user/view', 'id' => $model->id]) ?> class="btn btn_more"><?= \Yii::t('common', 'view more')?></a>
    </div>
</div>
<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h4><?= Html::encode($model->name) ?></h4>

    <?= HtmlPurifier::process($model->id_manager) ?>
</div>
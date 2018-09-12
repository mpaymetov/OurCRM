<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

?>
<div class="col-md-6">
    <div class="post panel">
        <div class="panel-body">
            <p class="post_number"><?= \Yii::t('common', 'event number: ') ?><?= HtmlPurifier::process($model->id_event) ?></p>
            <h3><?= Html::encode($model->message) ?></h3>
            <p><?= html::encode($model->created) ?></p>
            <form action="event.php">
                <p>is active<input type="checkbox" class="status" <?php if ($model->is_active == 1) echo "checked" ?>
                                   id="<?= HtmlPurifier::process($model->id_event) ?>"></p>
            </form>
            <a href='<?= Url::to(['event/view', 'id' => $model->id_event]) ?>'
               class="btn btn_more"><?= \Yii::t('common', 'view more') ?></a>
        </div>
    </div>
</div>


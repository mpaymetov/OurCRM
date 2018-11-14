<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;


?>
<div class="post panel">
    <div class="panel-body">
        <form class="active_button" action="event.php">
            <p>active <input type="checkbox" class="status"
                    <?php if ($model->is_active == 1) echo "checked" ?> id="<?= HtmlPurifier::process($model->id_event) ?>">
            </p>
        </form>
        <p class="post_number"><?= \Yii::t('common', 'event number: ') ?> <?= HtmlPurifier::process($model->id_event) ?></p>

        <h4><?= Html::encode($model->message) ?></h4>
        <a href=<?= Url::toRoute(['event/view', 'id' => $model->id_event]) ?> class="btn
           btn_more"><?= \Yii::t('common', 'view more') ?></a>
    </div>
</div>

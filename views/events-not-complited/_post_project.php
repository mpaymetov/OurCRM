<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;


?>
<div class="post panel">
    <div class="panel-body">
        <form class="active_button" action="event.php">
            <p>active <input type="checkbox" class="status"
                    <?php if ($model->is_active == 1) echo "checked" ?> id="<?= HtmlPurifier::process($model->id_project) ?>">
            </p>
        </form>
        <p class="post_number"><?= \Yii::t('common', 'project number: ') ?> <?= HtmlPurifier::process($model->id_project) ?></p>

        <h4><?= Html::encode($model->comment) ?></h4>
        <a href=<?= Url::toRoute(['project/view', 'id' => $model->id_project]) ?> class="btn
           btn_more"><?= \Yii::t('common', 'view more') ?></a>
    </div>
</div>

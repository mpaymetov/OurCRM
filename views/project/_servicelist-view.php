<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="serviceset-info">
 <div>
  <h3>
     <?php
        echo \Yii::t('common', 'serviceset number: ');
        echo HtmlPurifier::process($model['id']);
     ?>
  </h3>
  <a href='<?= Url::to(['serviceset/update', 'id' => $model['id']]) ?>' class="btn btn-primary pull-right"><?= \Yii::t('common', 'Update')?></a>
  <p>
      <?php
      echo \Yii::t('common', 'State: ');
      echo Html::encode($model['state']);
      ?>
  </p>
 </div>
</div>


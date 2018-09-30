<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="serviceset-info">
 <div>
   <div class="serviceset-info-title">
     <h3>
         <?php
            echo \Yii::t('common', 'Serviceset number') . ': ';
            echo HtmlPurifier::process($model['id']);
         ?>
     </h3>
   </div>
  <p class="pull-right">
     <?= Html::a(\Yii::t('common', 'Update'), ['serviceset/update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>

     <?= Html::a(\Yii::t('common', 'Delete'), ['serviceset/delete', 'id' => $model['id']], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ]) ?>
  </p>
  <p>
      <?php
      echo \Yii::t('common', 'State') . ': ';
      echo Html::encode($model['state']);
      ?>
  </p>
 </div>
</div>

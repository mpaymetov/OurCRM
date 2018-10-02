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
  <div>
      <?php
      echo Html::beginForm( 'project/close', 'post');
      echo Html::checkbox('agree', false, ['label' => \Yii::t('common', 'Close project')]);
      echo Html::endForm();
      ?>
  </div>
  <div>
     <?php
     echo Html::beginForm( 'project/payment', 'post');
     echo Html::checkbox('agree', false, ['label' => \Yii::t('common', 'Paid')]);
     echo Html::endForm();
     ?>
  </div>
  <div>
      <?php
      echo \Yii::t('common', 'State') . ': ';
      echo Html::encode($model['state']);
      ?>
  </div>
  <div>
      <?php
      echo \Yii::t('common', 'Payment') . ': ';
      if ($model['payment'] != null) {
          echo Html::encode($model['payment']);
      } else {
          echo Html::encode('--');
      }
      ?>
  </div>
  <div>
      <?php
      echo \Yii::t('common', 'Delivery') . ': ';
      if ($model['delivery'] != null) {
          echo Html::encode($model['delivery']);
      } else {
          echo Html::encode('--');
      }
      ?>
  </div>
 </div>
</div>

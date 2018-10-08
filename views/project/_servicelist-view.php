<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="serviceset-info">
  <h3 class="serviceset-info-title">
     <?php
        echo \Yii::t('common', 'Serviceset number') . ': ';
        echo HtmlPurifier::process($model['id']);
     ?>
  </h3>

  <div class="close pull-left">
    <?php
        $optionClose = ['class' => 'btn btn-primary'];
        $optionСancellation = ['class' => 'btn btn-default'];
        if ($model['isOpen'] == '0') {
            Html::addCssClass($optionClose,  ['not_click', 'disabled']);
            Html::addCssClass($optionСancellation, ['not_click', 'disabled']);
        }
        echo Html::a(\Yii::t('common', 'Close'), ['serviceset/close', 'id' => $model['id']], $optionClose);
        echo Html::a(\Yii::t('common', 'Сancellation'), ['serviceset/cancellation', 'id' => $model['id']], $optionСancellation);
    ?>
  </div>

  <div class="crud pull-right">
     <?php
     $optionUpdate = ['class' => 'btn btn-primary'];
     $optionDelet = [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post']
          ];
     if($model['isOpen'] == '0') {
         Html::addCssClass($optionUpdate,  ['not_click', 'disabled']);
         Html::addCssClass($optionDelet, ['not_click', 'disabled']);
     }
     echo Html::a(\Yii::t('common', 'Update'), ['serviceset/update', 'id' => $model['id']], $optionUpdate);
     echo Html::a(\Yii::t('common', 'Delete'), ['serviceset/delete', 'id' => $model['id']], $optionDelet); ?>
  </div>

  <div class="status-bar btn-group btn-group-justified">
    <?php
        $option = ['class' => 'btn btn-success'];
        if ($model['isOpen'] == '0') {
            Html::addCssClass($option,  ['not_click', 'disabled']);
        }
        for ($i = 0; $i < count($model['list']) - 2; $i++ )
        {
            if($i > $model['state']['id_state']) {
                Html::removeCssClass($option, 'btn-success');
                Html::addCssClass($option, 'btn-warning');
        }
            echo Html::a($model['list'][$i], ['serviceset/delete', 'id' => $model['id']], $option);
        }
    ?>
  </div>

    <?php
      /*$checked = ($model['isOpen'] == '0');
      $option = ['label' => \Yii::t('common', 'Close project')];
      if ($model['isOpen'] == '0') {
          $option['disabled'] = true;
      }
      echo Html::beginForm( 'project/close', 'post', ['name' => 'close-project_form']);
      echo Html::checkbox('close-project', $checked, $option);
      echo Html::endForm();*/
      ?>

     <?php
     /*$checked = ($model['payment'] != null);
     $option = ['label' => \Yii::t('common', 'Paid')];
     if ($model['payment'] != null) {
         $option['disabled'] = true;
     }
     echo Html::beginForm( 'project/payment', 'post', ['name' => 'payment-check_form']);
     echo Html::checkbox('pay', $checked, $option);
     echo Html::endForm();*/
     ?>
  <div>
      <?php
      echo \Yii::t('common', 'State') . ': ';
      echo Html::encode($model['state']['name']);
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

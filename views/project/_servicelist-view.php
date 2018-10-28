<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use app\models\StateCheck;

$options = ['class' => 'serviceset-info-' . $model['id']];
echo Html::beginTag('div', $options);
    $content = \Yii::t('common', 'Serviceset number') . ': ' . HtmlPurifier::process($model['id']);

    echo Html::tag('h3', $content, ['class'=>'serviceset-info-title']);

    echo Html::beginTag('div', ['class'=>'close pull-left']);
        $optionClose = ['class' => 'btn btn-primary'];
        $optionСancellation = ['class' => 'btn btn-default'];
        if ($model['isOpen'] == 0) {
            Html::addCssClass($optionClose,  ['not_click', 'disabled']);
            Html::addCssClass($optionСancellation, ['not_click', 'disabled']);
        }
        echo Html::a(\Yii::t('common', 'Close'), ['serviceset/close', 'id' => $model['id']], $optionClose);
        echo Html::a(\Yii::t('common', 'Сancellation'), ['serviceset/cancel', 'id' => $model['id']], $optionСancellation);
    echo Html::endTag('div');

    echo Html::beginTag('div', ['class'=>'crud pull-right']);
        $optionUpdate = ['class' => 'btn btn-primary'];
        $optionDelet = [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post']
        ];
        if($model['isOpen'] == 0) {
             Html::addCssClass($optionUpdate,  ['not_click', 'disabled']);
             Html::addCssClass($optionDelet, ['not_click', 'disabled']);
        }
        echo Html::a(\Yii::t('common', 'Update'), ['serviceset/update', 'id' => $model['id']], $optionUpdate);
        echo Html::a(\Yii::t('common', 'Delete'), ['serviceset/delete', 'id' => $model['id']], $optionDelet);
    echo Html::endTag('div');

    $statusOption = ['class' => 'btn-group btn-group-justified status-bar-' . $model['id']];
    $stateName = new StateCheck();
    echo Html::beginTag('div', $statusOption);
        $option = ['class' => 'btn btn-success status-item'];
        if ($model['isOpen'] == 0) {
            Html::addCssClass($option,  ['not_click', 'disabled']);
        }
        for ($i = $stateName::MakeContact; $i <= $stateName::Delivery; $i++) {
            Html::addCssClass($option, 'status-' . $i);
             if($i > $model['state']['id_state']) {
                Html::removeCssClass($option, 'btn-success');
                Html::addCssClass($option, 'btn-warning');
             }
             echo Html::a($model['list'][$i], ['serviceset/status', 'id' => $model['id']], $option);
            Html::removeCssClass($option, 'status-' . $i);
        }
    echo Html::endTag('div');

    $content = \Yii::t('common', 'State') . ': ' . Html::encode($model['state']['name']);
    echo Html::tag('div', $content, []);

    $content =  \Yii::t('common', 'Payment') . ': ';
    if ($model['payment'] != null) {
        $content .= Html::encode($model['payment']);
    } else {
        $content .= Html::encode('--');
    }
    echo Html::tag('div', $content, ['class'=>'payment-' . $model['id']]);

    $content = \Yii::t('common', 'Delivery') . ': ';
    if ($model['delivery'] != null) {
        $content .= Html::encode($model['delivery']);
    } else {
        $content .= Html::encode('--');
    }
    echo Html::tag('div', $content, ['class'=>'delivery-' . $model['id']]);
echo Html::endTag('div');
?>

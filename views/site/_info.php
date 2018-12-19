<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.10.2018
 * Time: 21:20
 */

use yii\helpers\Html;
use yii\helpers\Url;

echo Html::beginTag('div', ['class'=>'serviceset_info post panel']);
echo Html::beginTag('div', ['class'=>'panel-body']);

$content = \Yii::t('common', 'Client') . ': ' . html::encode($model['client']);
echo Html::tag('p', $content);

$content = \Yii::t('common', 'Project') . ': ' . html::encode($model['project_name']);
echo Html::tag('p', $content);

//$content = \Yii::t('common', 'Create date: ') . html::encode($model['create_date']);
//echo Html::tag('p', $content);

//$content = \Yii::t('common', 'Payment date') . ': ' . html::encode($model['payment_date']);
//echo Html::tag('p', $content);

$content = \Yii::t('common', 'Cost') . ': ' . html::encode($model['cost']);
echo Html::tag('p', $content);

$content = \Yii::t('common', 'Comment') . ': ' . html::encode($model['comment']);
echo Html::tag('p', $content);

echo Html::a(\Yii::t('common', 'view more'), Url::to(['project/view', 'id' => $model['id']]));

echo Html::endTag('div');
echo Html::endTag('div');
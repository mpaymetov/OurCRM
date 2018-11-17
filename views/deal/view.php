<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use  yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\project */

?>

<div class="col-md-6">
    <div class="project-view">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $project->id_project], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $project->id_project], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <div class="post panel">
            <div class="panel-body">
                <p class="post_number"><?= \Yii::t('common', 'project number: ') ?> <?= HtmlPurifier::process($project->id_project) ?></p>
                <p><?= html::encode($project->comment) ?></p>
                <a href='<?= Url::to(['project/view', 'id' => $project->id_project]) ?>'
                   class="btn btn_more"><?= \Yii::t('common', 'view more') ?></a>
                <p class="post_number"><?= \Yii::t('common', 'client number: ') ?> <?= HtmlPurifier::process($client->id_client) ?></p>
                <p><?= html::encode($client->id_client) ?></p>
                <a href='<?= Url::to(['project/view', 'id' => $client->id_client]) ?>'
                   class="btn btn_more"><?= \Yii::t('common', 'view more') ?></a>
                <p>
                    <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $client->id_client], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $client->id_client], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
</div>

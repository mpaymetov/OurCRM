<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

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
            </div>
        </div>

    </div>
    <div class="client-view">
        <div class="post panel">
            <div class="panel-body">
                <h4><?= html::encode($client->name)?></h4>
                <p class="post_number"><?= \Yii::t('common', 'client number: ')?> <?= HtmlPurifier::process($client->id_client) ?></p>
                <p><?= html::encode($client->comment)?></p>
                <p class=" btn btn_more">
                    <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $client->id_client], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $client->id_client], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
        </div>
    </div>
</div>
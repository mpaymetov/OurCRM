<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
    <h1>Managers</h1>
    <ul>
        <?php foreach ($managers as $manager): ?>
            <li>
                <?= Html::encode("{$manager->id_manager} ({$manager->name})") ?>:
                <?= $manager->id_department ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
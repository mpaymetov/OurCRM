<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php  $head = new AppAsset();
        echo $head->css;
        echo $head->js;
        ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <div class="wrap">
        <div class="root" id="root">
            <script src="/js/bundle.js">
            </script>
        </div>



<?php /*
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => \Yii::t('common', 'Items'), 'url' => ['/item/index']],
        ['label' => \Yii::t('common', 'Client'), 'url' => ['/client/index']],
        ['label' => \Yii::t('common', 'Project'), 'url' => ['/project/index']],
        ['label' => \Yii::t('common', 'Not complited'), 'url' => ['/events-not-complited/index']],
        ['label' => \Yii::t('common', 'Department'), 'url' => ['/department/index']],
        ['label' => \Yii::t('common', 'Service'), 'url' => ['/service/index']],
        ['label' => \Yii::t('common', 'Event'), 'url' => ['/event/index']],
        ['label' => \Yii::t('common', 'Statistic'), 'url' => ['/statistic/index']],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => \Yii::t('common', 'Log in'), 'url' => ['/user/login']];
    } else {
        $menuItems[] = ['label' => \Yii::t('common', 'Users'), 'url' => ['/user/index']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/logout'], 'post')
            . Html::submitButton(
                \Yii::t('common', 'Logout (') . Yii::$app->user->identity->login . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems
    ]);
    NavBar::end();
    ?>

    <div class="container back_container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?> </p>
        <p class="pull-right"><?= Yii::powered() ?></p>

            <?= Html::beginForm(['/site/language'])?>
            <?= Html::dropDownList('language', Yii::$app->language, ['en' => 'English', 'ru' => 'Русский']) ?>
            <?= Html::submitButton('Change') ?>
            <?= Html::endForm() ?>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
*/ ?>
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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $menuItems =
    [
        ['label' => 'Home', 'url' => ['/']],
        ['label' => 'About', 'url' => ['/about']],
        ['label' => 'Contact', 'url' => ['/contact']],
     ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
    }
        else {

            $menuItems[] = ['label' => 'View Profile',
                'url' => ['/user/profile'],
                'linkOptions' => ['data-method' => 'post']];

            $menuItems[] = ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                'url' => ['/user/logout'],
                'linkOptions' => ['data-method' => 'post']];


            if (Yii::$app->user->can("admin")) {
                $menuItems[] = [
                    'label' => 'Admin Panel',
                    'items' => [
                        ['label' => 'Manage Users', 'url' => ['/user/admin']],
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Shops</li>',
                        ['label' => 'Create Shop', 'url' => ['/shop/create']],
                        ['label' => 'Manage Shops', 'url' => ['/shop/manage']],
                    ], 'linkOptions' => ['style' => 'color: #F00;'],
                ];
            }
    }



    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; VitFL <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

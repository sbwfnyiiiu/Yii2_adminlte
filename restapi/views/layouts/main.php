<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Carousel;
use yii\widgets\Breadcrumbs;
use restapi\assets\AppAsset;
use common\widgets\Alert;

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
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-static',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '关于我们', 'url' => ['/site/about']],
        ['label' => '联系我们', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <?php 
    echo Carousel::widget([
        'items' => [
            [
                'content' => '<img src="/images/14881853_xl.jpg"/>',
                'caption' => '<h4>This is 14881853_xl.jpg</h4><p>This is the caption text</p>',
                'options' => [
                    'style' => 'height: 600px;',
                ],
            ],
            [
                'content' => '<img src="/images/53402047_xl.jpg"/>',
                'caption' => '<h4>This is 53402047_xl.jpg</h4><p>This is the caption text</p>',
                'options' => [
                    'style' => 'height: 600px;',
                ],
            ],
            [
                'content' => '<img src="/images/photo-1475158574400-f135829cbda3.jpg"/>',
                'caption' => '<h4>This is photo-1475158574400-f135829cbda3.jpg</h4><p>This is the caption text</p>',
                'options' => [
                    'style' => 'height: 600px;',
                ],
            ],
        ],
        'controls' => [
            '<span class="glyphicon glyphicon-chevron-left"></span>', 
            '<span class="glyphicon glyphicon-chevron-right"></span>'
        ],
        'options' => [
        ],
    ]);
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
        <p class="pull-left">版权所有 &copy; <?= date('Y') ?></p>

        <p class="pull-right">技术支持 <a href="http://www.caicent.com" target="_blank">CAICENT TECHNOLOGY</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

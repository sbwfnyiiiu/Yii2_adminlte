<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activeLink = Yii::$app->urlManager->createAbsoluteUrl(['site/active-account', 'token' => $user->active_token]);
?>
<div class="password-reset">
    <p>尊敬的会员-<?= Html::encode($user->username) ?>，您好:</p>

    <p>请根据下面的链接激活您的物业家网账号（<b>如非本人操作请忽略，建议删除本邮件!</b>）:</p>

    <p><?= Html::a(Html::encode($activeLink), $activeLink) ?></p>
</div>

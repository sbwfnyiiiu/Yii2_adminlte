<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>尊敬的会员-<?= Html::encode($user->username) ?>，您好:</p>

    <p>请根据下面的链接重置您的物业家网账号密码（<b>有效期为15分钟，如非本人操作请忽略，建议删除本邮件!</b>）:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>

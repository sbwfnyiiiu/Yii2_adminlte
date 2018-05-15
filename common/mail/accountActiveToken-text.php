<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/active-account', 'token' => $user->active_token]);
?>
尊敬的会员-<?= $user->username ?>，您好:

请根据下面的链接激活您的物业家网账号（<b>如非本人操作请忽略，建议删除本邮件!</b>）:

<?= $resetLink ?>

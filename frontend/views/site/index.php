<?php
use yii\bootstrap\Carousel;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = '物业家 - 首页';

/* 定义首页数据块 */
$this->beginBlock('block1');
echo Carousel::widget([
    'items' => [
        [
            'content' => '<img src="/images/community.jpg"/>',
            'caption' => '<h4>文明 和谐 互助</h4><p>让社区变得更加美好</p>',
            'options' => [
            ],
        ],
        [
            'content' => '<img src="/images/supermarket.jpg"/>',
            'caption' => '<h4>实惠 方便 快捷</h4><p>在家就可选购日常生活用品</p>',
            'options' => [
            ],
        ],
        [
            'content' => '<img src="/images/services.jpg"/>',
            'caption' => '<h4>教育 资讯 出行</h4><p>为大家提供使用，有趣的信息</p>',
            'options' => [
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
$this->endBlock();
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>社区</h2>

                <p>互联社区，提供ISTCE模式，为小区居民提供极速服务，为数字中国添砖加瓦。我们将为您提供全方位的数字体验，享受便捷生活；让美好事情在身边发生。</p>
                <p><a class="btn btn-default" href="#">社区入住 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <!-- <h2>超市</h2>

                <p>欢迎居民个人及微、小、中商户以入住网上超市，为您的社区提供生活、文化等用品3小时以内送货上门服务，给予社区会员更多优惠便利。</p>

                <p><a class="btn btn-default" href="#">进入商城 &raquo;</a></p> -->
                <h2>APP</h2>

                <p>欢迎居民个人及微、小、中商户以入住网上超市，为您的社区提供生活、文化等用品3小时以内送货上门服务，给予社区会员更多优惠便利。</p>

                <p><a class="btn btn-default" href="#">扫码安装 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <!-- <h2>服务</h2>

                <p>为小区居民提供教育、培训、医疗、旅游、图书、寻物、招聘等相关资讯及服务；本站技术人员亦对外提供网站、移动端（APP/微信）等开发业务。</p>

                <p><a class="btn btn-default" href="#">查看服务 &raquo;</a></p> -->
                <h2>微信</h2>

                <p>为小区居民提供教育、培训、医疗、旅游、图书、寻物、招聘等相关资讯及服务；本站技术人员亦对外提供网站、移动端（APP/微信）等开发业务。</p>

                <p><a class="btn btn-default" href="#">关注一下 &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
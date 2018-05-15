<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'smser' => [
            // 中国云信
            'class' => 'daixianceng\smser\CloudSmser',
            'username' => 'caicent',
            'password' => 'licm1982',
            'fileMode' => false
        ]
    ],
];

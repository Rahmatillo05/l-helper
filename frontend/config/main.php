<?php

use yii\rest\UrlRule;
use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'uz',
    'timeZone' => 'Asia/Tashkent',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'file-manager' => [
            'class' => 'frontend\modules\file\FileManager',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ]
        ],
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON
        ],
        'user' => [
            'identityClass' => 'common\models\user\User',
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'scriptUrl' => '/index.php',
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => [
                        'site',
                        'auth',
                        'file'
                    ],
                    'pluralize' => false
                ],
            ],
        ],

    ],
    'params' => $params,
];

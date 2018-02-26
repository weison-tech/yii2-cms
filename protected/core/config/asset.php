<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', realpath(__DIR__ . '/../../../'));
Yii::setAlias('@web', '/');

return [
    'jsCompressor' => 'gulp compress-js --gulpfile ./../tools/gulp/gulpfile.js --src {from} --dist {to}',
    'cssCompressor' => 'gulp compress-css --gulpfile ./../tools/gulp/gulpfile.js --src {from} --dist {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    // Asset bundle for compression output:
    'bundles' => [
        'core\modules\admin\assets\AdminLteAsset',
        'core\modules\home\assets\HomeAsset',
    ],
    'targets' => [
        'frontend' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-frontend-{hash}.js',
            'css' => 'all-frontend-{hash}.css',
            'depends' => [
                'core\modules\home\assets\HomeAsset'
            ],
        ],

        'admin' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-admin-{hash}.js',
            'css' => 'all-admin-{hash}.css',
        ], // Include all remaining assets
    ],

    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
    ],

];

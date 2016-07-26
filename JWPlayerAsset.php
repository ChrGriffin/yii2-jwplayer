<?php
namespace wadeshuler\jwplayer;

use yii\web\AssetBundle;

class JWPlayerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/wadeshuler/yii2-jwplayer/assets';
    public $js = ['jwplayer.js'];
    public $depends=[
        'yii\web\JqueryAsset'
    ];
}

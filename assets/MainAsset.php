<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


class MainAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/style.css',
		'css/open-iconic-bootstrap.css'
	];
	public $js = [
		'js/js.js'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\jui\JuiAsset',
	];
}

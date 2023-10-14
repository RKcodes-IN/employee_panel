<?php

namespace app\modules\admin\assets;

use yii\web\JqueryAsset;
use app\assets\FontAwesomeAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\jui\JuiAsset;
use yii\web\YiiAsset;

class AssetBundle extends \yii\web\AssetBundle
{
	public $sourcePath = '@app/modules/admin/assets/theme';

	public $css = [
		'css/core/libs.min.css',
		'vendor/aos/dist/aos.css',
		'css/hope-ui.min.css',
		'css/custom.min.css',
		'css/dark.min.css',
		'css/customizer.min.css',
		'css/core/libs.min.css',
	];

	public $js = [
		// 'js/core/libs.min.js',

		'js/core/external.min.js',
		'js/charts/widgetcharts.js',
		'js/charts/vectore-chart.js',
		'js/charts/dashboard.js',
		'js/plugins/fslightbox.js',
		'js/plugins/setting.js',
		'js/plugins/slider-tabs.js',
		'js/plugins/form-wizard.js',
		'vendor/aos/dist/aos.js',
		'js/hope-ui.js',

	];

	public $depends = [
		
		// AdminLteAsset::class,
		YiiAsset::class,
		JqueryAsset::class,
		JuiAsset::class,
		// BootstrapAsset::class,
		// BootstrapPluginAsset::class,
		FontAwesomeAsset::class,
		
	];
}

<?php

use yii\helpers\Html;
use app\widgets\FlashAlert;
use lo\modules\noty\Wrapper;
use app\modules\admin\assets\AssetBundle;
use kingston\mdbootstrap\MDBootstrapAsset;
use kingston\mdbootstrap\MDBootstrapPluginAsset;
use app\modules\admin\models\WebSetting;


/* @var $this \yii\web\View */
/* @var $content string */

AssetBundle::register($this);
// MDBootstrapAsset::register($this);
// MDBootstrapPluginAsset::register($this);

$adminlteAssets = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$setting = new WebSetting();

$icon = $setting->getSettingBykey('website_favicon');

$this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="<?= Yii::$app->charset ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<link rel="icon" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/uploads/<?php echo $icon; ?>" type="image/x-icon">

	<?php $this->head() ?>
	<!-- <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->

	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
</head>
<style>

</style>

<body class="">

	<?php $this->beginBody() ?>

	<div class="">
		<div class="row">
			<?= $content ?>
		</div>
	</div>




	<!-- ./wrapper -->

	<?php $this->endBody() ?>
	
</body>

</html>
<?php $this->endPage() ?>
<?php

use app\widgets\Block;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\admin\Module as AdminModule;

/* @var $this \yii\web\View */
?>
<?php if (Yii::$app->controller->id != "dashboard") { ?>
<?php Block::begin(['id' => 'content-header']) ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body d-flex justify-content-between align-items-center">
				<div class="card-title mb-0">
					<h4 class="mb-0">

						<?= Block::widget(['id' => 'content-title']) ?>

					</h4>
				</div>
				<div class="card-action">
					<!-- <a href="#" class="btn btn-primary" role="button">Back</a> -->

					<nav aria-label="breadcrumb">
						<?= Breadcrumbs::widget([
							'homeLink' => [
								'label' => 'Dashboard',
								'url' => ['/admin/dashboard'],
								'encode' => false,
							],
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
							'tag' => 'ol',
							'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
							'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
							'options' => [
								'class' => 'breadcrumb float-sm-right',
							],
						]) ?>
					</nav>

				</div>
			</div>
		</div>
	</div>
</div>
<?php Block::end(); ?>
<?php } ?>
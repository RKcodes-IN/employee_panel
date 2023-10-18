<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use app\modules\admin\widgets\Menu;
use app\models\User;
use yii\helpers\Url;

?>
<script src="https://templates.iqonic.design/hope-ui/html/dist/assets/js/core/libs.min.js"></script>
<style>

</style>
<aside class="sidebar sidebar-default navs-rounded-all ">
<?php if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN) { ?>
	<?= $this->render('admin-nav'); ?>
<?php } else { ?>
	<?= $this->render('user-nav'); ?>

<?php } ?>

</aside>
<!-- Main Sidebar Container -->
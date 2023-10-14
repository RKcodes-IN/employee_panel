<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SkipperPayout */

$this->title = Yii::t('app', 'Create Skipper Payout');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skipper Payouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skipper-payout-create">
    <div class="card">
       <div class="card-body">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
    </div>
</div>

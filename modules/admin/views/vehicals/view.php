<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Vehicals */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vehicles '), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicals-view">
<div class="card">
       <div class="card-body">
    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Vehicles ').' '. Html::encode($this->title) ?></h2>
        </div>
        
    </div>
    </div>
    </div>
    <div class="card">
       <div class="card-body">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'image',
        'base_fare',
        'min_distance',
        'fare_per_distance',
        'waiting_time_limit',
        'charges_per_minute',
        'cancellation_fee',
        'status',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
</div>
</div>
    </div>
    <div class="card">
       <div class="card-body">
    <div class="row">
<?php
if($providerPincode->totalCount){
    $gridColumnPincode = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'city.name',
                'label' => Yii::t('app', 'City')
            ],
            'name',
                        'price',
            'status',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerPincode,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-pincode']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Pincode')),
        ],
        'export' => false,
        'columns' => $gridColumnPincode
    ]);
}

?>
</div>
</div>
</div>

</div>


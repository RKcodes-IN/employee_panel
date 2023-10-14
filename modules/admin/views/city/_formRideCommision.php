<div class="form-group" id="add-ride-commision">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'RideCommision',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'vehicle_id' => [
            'label' => 'Vehicles ',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\modules\admin\models\Vehicals::find()->orderBy('title')->asArray()->all(), 'id', 'title'),
                'options' => ['placeholder' => Yii::t('app', 'Choose Vehicles ')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'base_fare' => ['type' => TabularForm::INPUT_TEXT],
        'min_distance' => ['type' => TabularForm::INPUT_TEXT],
        'fare_per_distance' => ['type' => TabularForm::INPUT_TEXT],
        'waiting_time_limit' => ['type' => TabularForm::INPUT_TEXT],
        'charges_per_minute' => ['type' => TabularForm::INPUT_TEXT],
        'fare_per_minute' => ['type' => TabularForm::INPUT_TEXT],
        'no_of_person' => ['type' => TabularForm::INPUT_TEXT],
        'commision' => ['type' => TabularForm::INPUT_TEXT],
        'status' => ['type'=>TabularForm::INPUT_DROPDOWN_LIST, 
            'items'=>[1 => 'Active', 0 => 'In Active', 2=>'Delete'],
            'columnOptions'=>['width'=>'185px']],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="fa fa-trash"></i>', '#', ['title' =>  Yii::t('app', 'Delete'), 'onClick' => 'delRowRideCommision(' . $key . '); return false;', 'id' => 'ride-commision-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="fa fa-plus"></i>' . Yii::t('app', 'Add Ride Commision'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowRideCommision()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>


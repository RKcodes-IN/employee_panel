<div class="form-group" id="add-driver-details">
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
    'formName' => 'DriverDetails',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'user_id' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->orderBy('username')->asArray()->all(), 'id', 'username'),
                'options' => ['placeholder' => Yii::t('app', 'Choose User')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'commission_percent' => ['type' => TabularForm::INPUT_TEXT],
        'city_id' => ['type' => TabularForm::INPUT_TEXT],
        'address' => ['type' => TabularForm::INPUT_TEXT],
        'lat' => ['type' => TabularForm::INPUT_TEXT],
        'lng' => ['type' => TabularForm::INPUT_TEXT],
        'location' => ['type' => TabularForm::INPUT_TEXT],
        'license_no' => ['type' => TabularForm::INPUT_TEXT],
        'proof_of_license' => ['type' => TabularForm::INPUT_TEXT],
        'proof_of_license_back' => ['type' => TabularForm::INPUT_TEXT],
        'rc_number' => ['type' => TabularForm::INPUT_TEXT],
        'vehical_number' => ['type' => TabularForm::INPUT_TEXT],
        'rc_proof' => ['type' => TabularForm::INPUT_TEXT],
        'rc_proof_back' => ['type' => TabularForm::INPUT_TEXT],
        'adhaar_number' => ['type' => TabularForm::INPUT_TEXT],
        'adhaar_front' => ['type' => TabularForm::INPUT_TEXT],
        'adhaar_back' => ['type' => TabularForm::INPUT_TEXT],
        'pan_number' => ['type' => TabularForm::INPUT_TEXT],
        'pan_front' => ['type' => TabularForm::INPUT_TEXT],
        'pan_back' => ['type' => TabularForm::INPUT_TEXT],
        'is_verified' => ['type' => TabularForm::INPUT_TEXT],
        'status' => ['type'=>TabularForm::INPUT_DROPDOWN_LIST, 
            'items'=>[1 => 'Active', 0 => 'In Active', 2=>'Delete'],
            'columnOptions'=>['width'=>'185px']],
        'form_steps' => ['type' => TabularForm::INPUT_TEXT],
        'document_steps' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="fa fa-trash"></i>', '#', ['title' =>  Yii::t('app', 'Delete'), 'onClick' => 'delRowDriverDetails(' . $key . '); return false;', 'id' => 'driver-details-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="fa fa-plus"></i>' . Yii::t('app', 'Add Driver Details'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowDriverDetails()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>


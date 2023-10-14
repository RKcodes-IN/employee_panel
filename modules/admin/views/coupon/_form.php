<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Coupon */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget([
    'viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'CouponsApplied',
        'relID' => 'coupons-applied',
        'value' => \yii\helpers\Json::encode($model->couponsApplieds),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="coupon-form">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form-inline',
        'type' => ActiveForm::TYPE_VERTICAL,
        'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
        'fieldConfig' => ['options' => ['class' => 'form-group col-xs-6 col-sm-6 col-md-6 col-lg-12']], // spacing field groups
        'formConfig' => ['showErrors' => true],
        // set style for proper tooltips error display
    ]); ?>

    <?= $form->errorSummary($model); ?>
    <div class="row">
        <div class='col-lg-6 '> <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        </div>
        <div class='col-lg-6'> <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']);  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'type_id')->dropDownList($model->getTypeOptions())->label('Coupon Type')  ?> </div>
       
        <div class='col-lg-6'> <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Code'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'discount')->textInput(['maxlength' => true, 'placeholder' => 'Discount'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'max_discount')->textInput(['maxlength' => true, 'placeholder' => 'Max Discount'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'min_ride_amount')->textInput(['placeholder' => 'Min Ride Amount'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'max_use')->textInput(['placeholder' => 'Max Use'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'max_use_of_coupon')->textInput(['placeholder' => 'Max Use Of Coupon'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'start_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                                    'saveFormat' => 'php:Y-m-d H:i:s',
                                    'ajaxConversion' => true,
                                    'options' => [
                                        'pluginOptions' => [
                                            'placeholder' => Yii::t('app', 'Choose Start Date'),
                                            'autoclose' => true,
                                        ]
                                    ],
                                ]);  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'end_date')->widget(\kartik\datecontrol\DateControl::classname(), [
                                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                                    'saveFormat' => 'php:Y-m-d H:i:s',
                                    'ajaxConversion' => true,
                                    'options' => [
                                        'pluginOptions' => [
                                            'placeholder' => Yii::t('app', 'Choose End Date'),
                                            'autoclose' => true,
                                        ]
                                    ],
                                ]);  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'is_global')->checkbox()  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'status')->dropDownList($model->getStateOptions())  ?> </div>


        <div class='col-lg-12'> <?= $form->field($model, 'description')->textarea()->label('Description') ?> </div>


    </div> <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
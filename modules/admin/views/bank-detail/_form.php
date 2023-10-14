<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BankDetail */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="bank-detail-form">

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
         <div class='col-lg-6 '>   <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

 </div> <div class='col-lg-6'>    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']);  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'user_id')->textInput(['placeholder' => 'User'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true, 'placeholder' => 'Bank Name'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'account_holder_name')->textInput(['maxlength' => true, 'placeholder' => 'Account Holder Name'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true, 'placeholder' => 'Account Number'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true, 'placeholder' => 'Branch Name'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'ifsc_code')->textInput(['maxlength' => true, 'placeholder' => 'Ifsc Code'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'upi_id')->textInput(['maxlength' => true, 'placeholder' => 'Upi'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'status')->dropDownList($model->getStateOptions())  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'type_id')->textInput(['placeholder' => 'Type'])  ?> </div>

 </div> <?php if($model->isNewRecord){ ?><?php } ?>    <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

    <?php ActiveForm::end(); ?>

</div>
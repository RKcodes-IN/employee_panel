<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SubmittedResume */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="submitted-resume-form">

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

 <div class='col-lg-6'>    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options' => ['placeholder' => Yii::t('app', 'Choose User')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'resume_id')->textInput(['placeholder' => 'Resume'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'date_of_birth')->textInput(['maxlength' => true, 'placeholder' => 'Date Of Birth'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'gender')->textInput(['maxlength' => true, 'placeholder' => 'Gender'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'nationality')->textInput(['maxlength' => true, 'placeholder' => 'Nationality'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'marital_status')->textInput(['maxlength' => true, 'placeholder' => 'Marital Status'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'passport')->textInput(['maxlength' => true, 'placeholder' => 'Passport'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'hobbies')->textInput(['maxlength' => true, 'placeholder' => 'Hobbies'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'languages')->textInput(['maxlength' => true, 'placeholder' => 'Languages'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'address')->textarea(['rows' => 6])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'landmark')->textInput(['maxlength' => true, 'placeholder' => 'Landmark'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'City'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => 'State'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'pincode')->textInput(['maxlength' => true, 'placeholder' => 'Pincode'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true, 'placeholder' => 'Mobile'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'ssc_result')->textInput(['maxlength' => true, 'placeholder' => 'Ssc Result'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'ssc_board')->textInput(['maxlength' => true, 'placeholder' => 'Ssc Board'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'ssc_pass_year')->textInput(['maxlength' => true, 'placeholder' => 'Ssc Pass Year'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'hsc_result')->textInput(['maxlength' => true, 'placeholder' => 'Hsc Result'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'hsc_board')->textInput(['maxlength' => true, 'placeholder' => 'Hsc Board'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'hsc_pass_year')->textInput(['maxlength' => true, 'placeholder' => 'Hsc Pass Year'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'graduation_degree')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Degree'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'graduation_result')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Result'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'graduation_univesity')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Univesity'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'graduation_year')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Year'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'post_graduatiion_degree')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Degree'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'post_graduatiion_result')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Result'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'post_graduatiion_year')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Year'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'post_graduatiion_univesity')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Univesity'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'high_level_education')->textInput(['maxlength' => true, 'placeholder' => 'High Level Education'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'total_work_experience')->textInput(['maxlength' => true, 'placeholder' => 'Total Work Experience'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'total_work_experience_in')->textInput(['maxlength' => true, 'placeholder' => 'Total Work Experience In'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'no_of_companies')->textInput(['maxlength' => true, 'placeholder' => 'No Of Companies'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'last_employer')->textInput(['maxlength' => true, 'placeholder' => 'Last Employer'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'submission_status')->textInput(['maxlength' => true, 'placeholder' => 'Submission Status'])  ?> </div>

 <div class='col-lg-6'>    <?= $form->field($model, 'status')->dropDownList($model->getStateOptions())  ?> </div>

 </div> <?php if($model->isNewRecord){ ?><?php } ?>    <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

    <?php ActiveForm::end(); ?>

</div>
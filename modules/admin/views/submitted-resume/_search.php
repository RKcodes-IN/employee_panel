<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\search\SubmittedResumeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-submitted-resume-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options' => ['placeholder' => Yii::t('app', 'Choose User')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'resume_id')->textInput(['placeholder' => 'Resume']) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name']) ?>

    <?php /* echo $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) */ ?>

    <?php /* echo $form->field($model, 'date_of_birth')->textInput(['maxlength' => true, 'placeholder' => 'Date Of Birth']) */ ?>

    <?php /* echo $form->field($model, 'gender')->textInput(['maxlength' => true, 'placeholder' => 'Gender']) */ ?>

    <?php /* echo $form->field($model, 'nationality')->textInput(['maxlength' => true, 'placeholder' => 'Nationality']) */ ?>

    <?php /* echo $form->field($model, 'marital_status')->textInput(['maxlength' => true, 'placeholder' => 'Marital Status']) */ ?>

    <?php /* echo $form->field($model, 'passport')->textInput(['maxlength' => true, 'placeholder' => 'Passport']) */ ?>

    <?php /* echo $form->field($model, 'hobbies')->textInput(['maxlength' => true, 'placeholder' => 'Hobbies']) */ ?>

    <?php /* echo $form->field($model, 'languages')->textInput(['maxlength' => true, 'placeholder' => 'Languages']) */ ?>

    <?php /* echo $form->field($model, 'address')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'landmark')->textInput(['maxlength' => true, 'placeholder' => 'Landmark']) */ ?>

    <?php /* echo $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'City']) */ ?>

    <?php /* echo $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => 'State']) */ ?>

    <?php /* echo $form->field($model, 'pincode')->textInput(['maxlength' => true, 'placeholder' => 'Pincode']) */ ?>

    <?php /* echo $form->field($model, 'mobile')->textInput(['maxlength' => true, 'placeholder' => 'Mobile']) */ ?>

    <?php /* echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) */ ?>

    <?php /* echo $form->field($model, 'ssc_result')->textInput(['maxlength' => true, 'placeholder' => 'Ssc Result']) */ ?>

    <?php /* echo $form->field($model, 'ssc_board')->textInput(['maxlength' => true, 'placeholder' => 'Ssc Board']) */ ?>

    <?php /* echo $form->field($model, 'ssc_pass_year')->textInput(['maxlength' => true, 'placeholder' => 'Ssc Pass Year']) */ ?>

    <?php /* echo $form->field($model, 'hsc_result')->textInput(['maxlength' => true, 'placeholder' => 'Hsc Result']) */ ?>

    <?php /* echo $form->field($model, 'hsc_board')->textInput(['maxlength' => true, 'placeholder' => 'Hsc Board']) */ ?>

    <?php /* echo $form->field($model, 'hsc_pass_year')->textInput(['maxlength' => true, 'placeholder' => 'Hsc Pass Year']) */ ?>

    <?php /* echo $form->field($model, 'graduation_degree')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Degree']) */ ?>

    <?php /* echo $form->field($model, 'graduation_result')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Result']) */ ?>

    <?php /* echo $form->field($model, 'graduation_univesity')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Univesity']) */ ?>

    <?php /* echo $form->field($model, 'graduation_year')->textInput(['maxlength' => true, 'placeholder' => 'Graduation Year']) */ ?>

    <?php /* echo $form->field($model, 'post_graduatiion_degree')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Degree']) */ ?>

    <?php /* echo $form->field($model, 'post_graduatiion_result')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Result']) */ ?>

    <?php /* echo $form->field($model, 'post_graduatiion_year')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Year']) */ ?>

    <?php /* echo $form->field($model, 'post_graduatiion_univesity')->textInput(['maxlength' => true, 'placeholder' => 'Post Graduatiion Univesity']) */ ?>

    <?php /* echo $form->field($model, 'high_level_education')->textInput(['maxlength' => true, 'placeholder' => 'High Level Education']) */ ?>

    <?php /* echo $form->field($model, 'total_work_experience')->textInput(['maxlength' => true, 'placeholder' => 'Total Work Experience']) */ ?>

    <?php /* echo $form->field($model, 'total_work_experience_in')->textInput(['maxlength' => true, 'placeholder' => 'Total Work Experience In']) */ ?>

    <?php /* echo $form->field($model, 'no_of_companies')->textInput(['maxlength' => true, 'placeholder' => 'No Of Companies']) */ ?>

    <?php /* echo $form->field($model, 'last_employer')->textInput(['maxlength' => true, 'placeholder' => 'Last Employer']) */ ?>

    <?php /* echo $form->field($model, 'submission_status')->textInput(['maxlength' => true, 'placeholder' => 'Submission Status']) */ ?>

    <?php /* echo $form->field($model, 'status')->dropDownList($model->getStateOptions()) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

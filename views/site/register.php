<?php

use app\models\User;
use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

<style>
    .card {
        padding: 50px;
    }

    .row {
        align-items: center !important;
    }

    nav {
        display: none !important;
    }
</style>

<section class="login-content">
    <div class="row m-0 align-items-center bg-white vh-100">

        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">

                        <h2 class="mb-2 text-center">Sign Up</h2>
                        <p class="text-center">Create your account.</p>
                        <?php


                        $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                        ]); ?>


                        <div class="row">


                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true,]) ?>
                                </div>
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'password')->passwordInput() ?>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

                            </div>

                        </div>

                        <div class="">
                            <?= Html::submitButton($model->isNewRecord ? 'Sign Up' : 'Update', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</section>
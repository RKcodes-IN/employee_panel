<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\City */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget([
    'viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Pincode',
        'relID' => 'pincode',
        'value' => \yii\helpers\Json::encode($model->pincodes),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget([
    'viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'RideCommision',
        'relID' => 'ride-commision',
        'value' => \yii\helpers\Json::encode($model->rideCommisions),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="city-form">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form-inline',
        'type' => ActiveForm::TYPE_VERTICAL,
        'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
        'fieldConfig' => ['options' => ['class' => 'form-group col-xs-6 col-sm-6 col-md-6 col-lg-12']], // spacing field groups
        'formConfig' => ['showErrors' => true],
        // set style for proper tooltips error display
    ]); ?>

    <?= $form->errorSummary($model); ?>
    <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class='col-lg-6 '> <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        </div>
        <div class='col-lg-6'> <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']);  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name'])  ?> </div>

        <div class='col-lg-6'> <?= $form->field($model, 'status')->dropDownList($model->getStateOptions())  ?> </div>

    </div> <?php if ($model->isNewRecord) { ?> <?php
                                                $forms = [
                                                    [
                                                        'label' => '<i class="fa fa-book"></i> ' . Html::encode(Yii::t('app', 'Pincode')),
                                                        'content' => $this->render('_formPincode', [
                                                            'row' => \yii\helpers\ArrayHelper::toArray($model->pincodes),
                                                        ]),
                                                    ],
                                                    [
                                                        'label' => '<i class="fa fa-book"></i> ' . Html::encode(Yii::t('app', 'Fare & Commision')),
                                                        'content' => $this->render('_formRideCommision', [
                                                            'row' => \yii\helpers\ArrayHelper::toArray($model->rideCommisions),
                                                        ]),
                                                    ],
                                                ];
                                                echo kartik\tabs\TabsX::widget([
                                                    'items' => $forms,
                                                    'position' => kartik\tabs\TabsX::POS_ABOVE,
                                                    'encodeLabels' => false,
                                                    'pluginOptions' => [
                                                        'bordered' => true,
                                                        'sideways' => true,
                                                        'enableCache' => false,
                                                    ],
                                                ]);
                                                ?>
    <?php } ?> <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Vehicals */
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
?>

<div class="vehicals-form">

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

        <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']);  ?>

        <div class='col-lg-12'> <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title'])  ?> </div>











    </div>
    <div class='col-lg-8' style="display: block; margin: 0 auto;"> <?php

                                                                    echo $form->field($model, 'image')->widget(FileInput::classname(), [
                                                                        'options' => ['multiple' => false, 'accept' => 'image/*'],
                                                                        'pluginOptions' => [
                                                                            'previewFileType' => 'image', 'initialPreview' => [
                                                                                $model->image
                                                                            ],
                                                                            'initialPreviewAsData' => true,

                                                                            'overwriteInitial' => true,

                                                                            'showUpload' => false,
                                                                        ]
                                                                    ]);  ?> </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
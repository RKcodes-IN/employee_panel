<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\search\WalletSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-wallet-search">

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

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'placeholder' => 'Amount']) ?>

    <?= $form->field($model, 'payment_type')->textInput(['placeholder' => 'Payment Type']) ?>

    <?= $form->field($model, 'method_reason')->textInput(['maxlength' => true, 'placeholder' => 'Method Reason']) ?>

    <?php /* echo $form->field($model, 'type_id')->textInput(['placeholder' => 'Type']) */ ?>

    <?php /* echo $form->field($model, 'status')->dropDownList($model->getStateOptions()) */ ?>

    <?php /* echo $form->field($model, 'created_user_id')->textInput(['placeholder' => 'Created User']) */ ?>

    <?php /* echo $form->field($model, 'updated_user_id')->textInput(['placeholder' => 'Updated User']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

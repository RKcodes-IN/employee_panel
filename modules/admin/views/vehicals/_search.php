<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\search\VehicalsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-vehicals-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true, 'placeholder' => 'Image']) ?>

    <?= $form->field($model, 'base_fare')->textInput(['placeholder' => 'Base Fare']) ?>

    <?= $form->field($model, 'min_distance')->textInput(['placeholder' => 'Min Distance']) ?>

    <?php /* echo $form->field($model, 'fare_per_distance')->textInput(['placeholder' => 'Fare Per Distance']) */ ?>

    <?php /* echo $form->field($model, 'waiting_time_limit')->textInput(['placeholder' => 'Waiting Time Limit']) */ ?>

    <?php /* echo $form->field($model, 'charges_per_minute')->textInput(['placeholder' => 'Charges Per Minute']) */ ?>

    <?php /* echo $form->field($model, 'cancellation_fee')->textInput(['placeholder' => 'Cancellation Fee']) */ ?>

    <?php /* echo $form->field($model, 'status')->dropDownList($model->getStateOptions()) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

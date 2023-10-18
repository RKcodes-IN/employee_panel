<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SubmittedResume */

$this->title = Yii::t('app', 'Create Submitted Resume');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Submitted Resumes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submitted-resume-create">
    <div class="card">
        <div class="card-body">
            <!-- <h1><?= Html::encode($this->title) ?></h1> -->

            <?= $this->render('_form', [
                'model' => $model,
                'resumes' => $resumes,
            ]) ?>
        </div>
    </div>
</div>
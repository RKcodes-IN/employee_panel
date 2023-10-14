<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\SubmittedResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\models\User;
use app\modules\admin\models\base\Banner;

use kartik\grid\GridView;

$this->title = Yii::t('app', 'Submitted Resumes');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);


?>
<div class="submitted-resume-index">
<div class="card">
       <div class="card-body">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php  if(\Yii::$app->user->identity->user_role==User::ROLE_ADMIN || \Yii::$app->user->identity->user_role==User::ROLE_SUBADMIN){ ?>
        <?= Html::a(Yii::t('app', 'Create Submitted Resume'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php  } ?>
        <?= Html::a(Yii::t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
        </div>
    </div>
    <div class="card">
       <div class="card-body">
<?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
   
        ['attribute' => 'id', 'visible' => false],
   
        [
                'attribute' => 'user_id',
                'label' => Yii::t('app', 'User'),
                'value' => function($model){                   
                    return $model->user->username;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->asArray()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid-submitted-resume-search-user_id']
            ],
   
        'resume_id',
   
        'first_name',
   
        'middle_name',
   
        'last_name',
   
        'date_of_birth',
   
        'gender',
   
        'nationality',
   
        'marital_status',
   
        'passport',
   
        'hobbies',
   
        'languages',
   
        'address:ntext',
   
        'landmark',
   
        'city',
   
        'state',
   
        'pincode',
   
        'mobile',
   
        'email:email',
   
        'ssc_result',
   
        'ssc_board',
   
        'ssc_pass_year',
   
        'hsc_result',
   
        'hsc_board',
   
        'hsc_pass_year',
   
        'graduation_degree',
   
        'graduation_result',
   
        'graduation_univesity',
   
        'graduation_year',
   
        'post_graduatiion_degree',
   
        'post_graduatiion_result',
   
        'post_graduatiion_year',
   
        'post_graduatiion_univesity',
   
        'high_level_education',
   
        'total_work_experience',
   
        'total_work_experience_in',
   
        'no_of_companies',
   
        'last_employer',
   
        'submission_status',
   
        [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){                   
                    return $model->getStateOptionsBadges();                   
                },
               
               
            ],
        [
            'class' => 'kartik\grid\ActionColumn',
             'template' => '{view} {update} {delete}',
             'buttons' => [
            'view'=> function($url,$model) {
            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN || \Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
                    return Html::a( '<span class="fas fa-eye" aria-hidden="true"></span>', $url);
                } 
                },
            'update'=> function($url,$model) {
            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN || \Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
                    return Html::a( '<span class="fas fa-pencil-alt" aria-hidden="true"></span>', $url);

                } 
                },
            'delete'=> function($url,$model) {
            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) {
                    return Html::a( '<span class="fas fa-trash-alt" aria-hidden="true"></span>', $url,[
                        'data' => [
                                    'method' => 'post',
                                     // use it if you want to confirm the action
                                     'confirm' => 'Are you sure?',
                                 ],
                                ]);
                } 
                },


        ]
            
           

        ],
    ];   
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-submitted-resume']],
        'panel' => [
            
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'export' => false,
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_PDF => false
                ]
            ]) ,
        ],
    ]); ?>
</div>
</div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).on('change','select[id^=status_list_]',function(){
var id=$(this).attr('data-id');
var val=$(this).val();

$.ajax({
	  type: "POST",
	 
      url: "/employee_panel/gii/default/status-change",
     
 
      data: {id:id,val:val},
	  success: function(data){
		  swal("Good job!", "Status Successfully Changed!", "success");
	  }
	});
});


</script>
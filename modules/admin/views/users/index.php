<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\modules\admin\widgets\BoxGridView;
use app\modules\admin\widgets\LinkedColumn;
use app\modules\admin\Module as AdminModule;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
    function sendRequest(status, id){
       if(status == true){
           val = 1;
       }else{
           val = 0;
       }
        $.ajax({
            url:'users/update-status',
            method:'post',
            data:{val:val,id:id},
            success:function(data){
              alert('status updated');
            },
            error:function(jqXhr,status,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js, \yii\web\View::POS_READY);

?>
<?php $this->beginBlock('content-title'); ?>
<?= Html::a('Add New', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
<?php $this->endBlock(); ?>

<div class="user-index">


	<div class="card">

		<div class="card-body">

			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel'  => $searchModel,
				'columns'      => [
					['class' => 'yii\grid\SerialColumn'],
					'id',
					/*[
				'class' => LinkedColumn::class,
				'header' => '<a href="#">id</a>',
				'attribute' => 'username',
				'value' => 'id',
			],*/
					[
						'class' => LinkedColumn::class,
						'header' => '<a href="#">Name</a>',
						'attribute' => 'first_name',
						'value' => 'first_name',
					],
					//'username',
					[
						'class' => LinkedColumn::class,
						'header' => '<a href="#">Email</a>',
						'attribute' => 'username',
						'value' => 'email',
					],
					'contact_no',
					'user_role',

					// [
					// 	'attribute' => 'status',
					// 	'format' => 'raw',
					// 	'value' => function ($data) {
					// 		return SwitchInput::widget(
					// 			[
					// 				'name' => 'status',
					// 				'pluginEvents' => [
					// 					'switchChange.bootstrapSwitch' => "function(e){sendRequest(e.currentTarget.checked, $data->id);}"
					// 				],

					// 				'pluginOptions' => [
					// 					'size' => 'mini',
					// 					'onColor' => 'success',
					// 					'offColor' => 'danger',
					// 					'onText' => 'Active',
					// 					'offText' => 'Inactive'
					// 				],
					// 				'value' => $data->status
					// 			]
					// 		);
					// 	}
					// ],
					[
						'attribute' => 'created_at',
					
						"format" => 'raw',
						'value' => function ($data) {
							$date = date('d/M/Y H:i:s', $data->created_at);
							
							return $date;
						}
					],
					///start now status 
					[
						'attribute' => 'status',
						'filter'  =>  \app\models\User::getStatusesList(),
						"format" => 'raw',
						'value' => function ($data) {
							$html = '';

							$html .= '<select id="status_list_' . $data->id . '" data-id="' . $data->id . '" >';
							$lists = $data->getStatusesList();

							foreach ($lists as $key => $list) {

								if ($key == $data->status) {
									$html .= '<option value="' . $key . '" selected>' . $list . '</option>';
								} else {
									$html .= '<option value="' . $key . '">' . $list . '</option>';
								}
							}
							$html .= '</select>';

							return $html;
						}
					],
					///end now status



					// 'updated_at',
					[
						'class' => 'kartik\grid\ActionColumn',
						'template' => '{view} {update} ',



					],
				],
			]); ?>

		</div>
	</div>
</div>
<!--  -->
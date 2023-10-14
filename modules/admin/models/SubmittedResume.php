<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\SubmittedResume as BaseSubmittedResume;

/**
 * This is the model class for table "submitted_resume".
 */
class SubmittedResume extends BaseSubmittedResume
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'resume_id', 'first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'nationality', 'marital_status', 'passport', 'hobbies', 'languages', 'address', 'landmark', 'city', 'state', 'pincode', 'mobile', 'email', 'ssc_result', 'ssc_board', 'ssc_pass_year', 'hsc_result', 'hsc_board', 'hsc_pass_year', 'graduation_degree', 'graduation_result', 'graduation_univesity', 'graduation_year', 'post_graduatiion_degree', 'post_graduatiion_result', 'post_graduatiion_year', 'post_graduatiion_univesity', 'high_level_education', 'total_work_experience', 'total_work_experience_in', 'no_of_companies', 'last_employer', 'submission_status', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['user_id', 'resume_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['address'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'nationality', 'marital_status', 'passport', 'hobbies', 'languages', 'landmark', 'city', 'state', 'pincode', 'mobile', 'email', 'ssc_result', 'ssc_board', 'ssc_pass_year', 'hsc_result', 'hsc_board', 'hsc_pass_year', 'graduation_degree', 'graduation_result', 'graduation_univesity', 'graduation_year', 'post_graduatiion_degree', 'post_graduatiion_result', 'post_graduatiion_year', 'post_graduatiion_univesity', 'high_level_education', 'total_work_experience', 'total_work_experience_in', 'no_of_companies', 'last_employer', 'submission_status', 'created_on', 'updated_on'], 'string', 'max' => 255]
        ]);
    }
	

}

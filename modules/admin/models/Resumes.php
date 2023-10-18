<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\Resumes as BaseResumes;

/**
 * This is the model class for table "resumes".
 */
class Resumes extends BaseResumes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            // [['name', 'resume_url', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            // [['status', 'created_on', 'updated_on'], 'integer'],
            // [['create_user_id', 'update_user_id'], 'safe'],
            // [['name', 'resume_url'], 'string', 'max' => 255]
        ]);
    }
	

}

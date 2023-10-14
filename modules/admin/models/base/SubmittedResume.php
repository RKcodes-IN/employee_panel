<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the base model class for table "submitted_resume".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $resume_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $gender
 * @property string $nationality
 * @property string $marital_status
 * @property string $passport
 * @property string $hobbies
 * @property string $languages
 * @property string $address
 * @property string $landmark
 * @property string $city
 * @property string $state
 * @property string $pincode
 * @property string $mobile
 * @property string $email
 * @property string $ssc_result
 * @property string $ssc_board
 * @property string $ssc_pass_year
 * @property string $hsc_result
 * @property string $hsc_board
 * @property string $hsc_pass_year
 * @property string $graduation_degree
 * @property string $graduation_result
 * @property string $graduation_univesity
 * @property string $graduation_year
 * @property string $post_graduatiion_degree
 * @property string $post_graduatiion_result
 * @property string $post_graduatiion_year
 * @property string $post_graduatiion_univesity
 * @property string $high_level_education
 * @property string $total_work_experience
 * @property string $total_work_experience_in
 * @property string $no_of_companies
 * @property string $last_employer
 * @property string $submission_status
 * @property integer $status
 * @property string $created_on
 * @property string $updated_on
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * @property \app\models\User $user
 */
class SubmittedResume extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'user'
        ];
    }

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;

    const IS_FEATURED = 1;
    const IS_NOT_FEATURED = 0;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'resume_id', 'first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'nationality', 'marital_status', 'passport', 'hobbies', 'languages', 'address', 'landmark', 'city', 'state', 'pincode', 'mobile', 'email', 'ssc_result', 'ssc_board', 'ssc_pass_year', 'hsc_result', 'hsc_board', 'hsc_pass_year', 'graduation_degree', 'graduation_result', 'graduation_univesity', 'graduation_year', 'post_graduatiion_degree', 'post_graduatiion_result', 'post_graduatiion_year', 'post_graduatiion_univesity', 'high_level_education', 'total_work_experience', 'total_work_experience_in', 'no_of_companies', 'last_employer', 'submission_status', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['user_id', 'resume_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['address'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'nationality', 'marital_status', 'passport', 'hobbies', 'languages', 'landmark', 'city', 'state', 'pincode', 'mobile', 'email', 'ssc_result', 'ssc_board', 'ssc_pass_year', 'hsc_result', 'hsc_board', 'hsc_pass_year', 'graduation_degree', 'graduation_result', 'graduation_univesity', 'graduation_year', 'post_graduatiion_degree', 'post_graduatiion_result', 'post_graduatiion_year', 'post_graduatiion_univesity', 'high_level_education', 'total_work_experience', 'total_work_experience_in', 'no_of_companies', 'last_employer', 'submission_status', 'created_on', 'updated_on'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'submitted_resume';
    }

    public function getStateOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',

            self::STATUS_INACTIVE => 'In Active',
            self::STATUS_DELETE => 'Deleted',

        ];
    }
    public function getStateOptionsBadges()
    {

        if ($this->status == self::STATUS_ACTIVE) {
            return '<span class="badge badge-success">Active</span>';
        } elseif ($this->status == self::STATUS_INACTIVE) {
            return '<span class="badge badge-warning">In Active</span>';
        }elseif ($this->status == self::STATUS_DELETE) {
            return '<span class="badge badge-danger">Deleted</span>';
        }

    }

    public function getFeatureOptions()
    {
        return [

            self::IS_FEATURED => 'Is Featured',
            self::IS_NOT_FEATURED => 'Not Featured',
           
        ];
    }

    public function getFeatureOptionsBadges()
    {
        if ($this->is_featured == self::IS_FEATURED) {
            return '<span class="badge badge-success">Featured</span>';
        } elseif ($this->is_featured == self::IS_NOT_FEATURED) {
            return '<span class="badge badge-danger">Not Featured</span>';
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'resume_id' => Yii::t('app', 'Resume ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'date_of_birth' => Yii::t('app', 'Date Of Birth'),
            'gender' => Yii::t('app', 'Gender'),
            'nationality' => Yii::t('app', 'Nationality'),
            'marital_status' => Yii::t('app', 'Marital Status'),
            'passport' => Yii::t('app', 'Passport'),
            'hobbies' => Yii::t('app', 'Hobbies'),
            'languages' => Yii::t('app', 'Languages'),
            'address' => Yii::t('app', 'Address'),
            'landmark' => Yii::t('app', 'Landmark'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'pincode' => Yii::t('app', 'Pincode'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'ssc_result' => Yii::t('app', 'Ssc Result'),
            'ssc_board' => Yii::t('app', 'Ssc Board'),
            'ssc_pass_year' => Yii::t('app', 'Ssc Pass Year'),
            'hsc_result' => Yii::t('app', 'Hsc Result'),
            'hsc_board' => Yii::t('app', 'Hsc Board'),
            'hsc_pass_year' => Yii::t('app', 'Hsc Pass Year'),
            'graduation_degree' => Yii::t('app', 'Graduation Degree'),
            'graduation_result' => Yii::t('app', 'Graduation Result'),
            'graduation_univesity' => Yii::t('app', 'Graduation Univesity'),
            'graduation_year' => Yii::t('app', 'Graduation Year'),
            'post_graduatiion_degree' => Yii::t('app', 'Post Graduatiion Degree'),
            'post_graduatiion_result' => Yii::t('app', 'Post Graduatiion Result'),
            'post_graduatiion_year' => Yii::t('app', 'Post Graduatiion Year'),
            'post_graduatiion_univesity' => Yii::t('app', 'Post Graduatiion Univesity'),
            'high_level_education' => Yii::t('app', 'High Level Education'),
            'total_work_experience' => Yii::t('app', 'Total Work Experience'),
            'total_work_experience_in' => Yii::t('app', 'Total Work Experience In'),
            'no_of_companies' => Yii::t('app', 'No Of Companies'),
            'last_employer' => Yii::t('app', 'Last Employer'),
            'submission_status' => Yii::t('app', 'Submission Status'),
            'status' => Yii::t('app', 'Status'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'create_user_id' => Yii::t('app', 'Create User ID'),
            'update_user_id' => Yii::t('app', 'Update User ID'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_on',
                'updatedAtAttribute' => 'updated_on',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'create_user_id',
                'updatedByAttribute' => 'update_user_id',
            ],
        ];
    }



    /**
     * @inheritdoc
     * @return \app\modules\admin\models\SubmittedResumeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\SubmittedResumeQuery(get_called_class());
    }
public function asJson(){
    $data = [] ; 
            $data['id'] =  $this->id;
        
                $data['user_id'] =  $this->user_id;
        
                $data['resume_id'] =  $this->resume_id;
        
                $data['first_name'] =  $this->first_name;
        
                $data['middle_name'] =  $this->middle_name;
        
                $data['last_name'] =  $this->last_name;
        
                $data['date_of_birth'] =  $this->date_of_birth;
        
                $data['gender'] =  $this->gender;
        
                $data['nationality'] =  $this->nationality;
        
                $data['marital_status'] =  $this->marital_status;
        
                $data['passport'] =  $this->passport;
        
                $data['hobbies'] =  $this->hobbies;
        
                $data['languages'] =  $this->languages;
        
                $data['address'] =  $this->address;
        
                $data['landmark'] =  $this->landmark;
        
                $data['city'] =  $this->city;
        
                $data['state'] =  $this->state;
        
                $data['pincode'] =  $this->pincode;
        
                $data['mobile'] =  $this->mobile;
        
                $data['email'] =  $this->email;
        
                $data['ssc_result'] =  $this->ssc_result;
        
                $data['ssc_board'] =  $this->ssc_board;
        
                $data['ssc_pass_year'] =  $this->ssc_pass_year;
        
                $data['hsc_result'] =  $this->hsc_result;
        
                $data['hsc_board'] =  $this->hsc_board;
        
                $data['hsc_pass_year'] =  $this->hsc_pass_year;
        
                $data['graduation_degree'] =  $this->graduation_degree;
        
                $data['graduation_result'] =  $this->graduation_result;
        
                $data['graduation_univesity'] =  $this->graduation_univesity;
        
                $data['graduation_year'] =  $this->graduation_year;
        
                $data['post_graduatiion_degree'] =  $this->post_graduatiion_degree;
        
                $data['post_graduatiion_result'] =  $this->post_graduatiion_result;
        
                $data['post_graduatiion_year'] =  $this->post_graduatiion_year;
        
                $data['post_graduatiion_univesity'] =  $this->post_graduatiion_univesity;
        
                $data['high_level_education'] =  $this->high_level_education;
        
                $data['total_work_experience'] =  $this->total_work_experience;
        
                $data['total_work_experience_in'] =  $this->total_work_experience_in;
        
                $data['no_of_companies'] =  $this->no_of_companies;
        
                $data['last_employer'] =  $this->last_employer;
        
                $data['submission_status'] =  $this->submission_status;
        
                $data['status'] =  $this->status;
        
                $data['created_on'] =  $this->created_on;
        
                $data['updated_on'] =  $this->updated_on;
        
                $data['create_user_id'] =  $this->create_user_id;
        
                $data['update_user_id'] =  $this->update_user_id;
        
            return $data;
}


}



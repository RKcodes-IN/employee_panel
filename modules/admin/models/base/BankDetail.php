<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
/**
 * This is the base model class for table "bank_detail".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $bank_name
 * @property string $account_holder_name
 * @property string $account_number
 * @property string $branch_name
 * @property string $ifsc_code
 * @property string $upi_id
 * @property integer $status
 * @property integer $type_id
 * @property string $created_on
 * @property string $updated_on
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class BankDetail extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            ''
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
            [['user_id', 'upi_id'], 'required'],
            [['user_id', 'status', 'type_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['bank_name', 'account_holder_name', 'account_number', 'branch_name', 'ifsc_code'], 'string', 'max' => 127],
            [['upi_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_detail';
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
            'bank_name' => Yii::t('app', 'Bank Name'),
            'account_holder_name' => Yii::t('app', 'Account Holder Name'),
            'account_number' => Yii::t('app', 'Account Number'),
            'branch_name' => Yii::t('app', 'Branch Name'),
            'ifsc_code' => Yii::t('app', 'Ifsc Code'),
            'upi_id' => Yii::t('app', 'Upi ID'),
            'status' => Yii::t('app', 'Status'),
            'type_id' => Yii::t('app', 'Type ID'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'create_user_id' => Yii::t('app', 'Create User ID'),
            'update_user_id' => Yii::t('app', 'Update User ID'),
        ];
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
     * @return \app\modules\admin\models\BankDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\BankDetailQuery(get_called_class());
    }
public function asJson(){
    $data = [] ; 
            $data['id'] =  $this->id;
        
                $data['user_id'] =  $this->user_id;
        
                $data['bank_name'] =  $this->bank_name;
        
                $data['account_holder_name'] =  $this->account_holder_name;
        
                $data['account_number'] =  $this->account_number;
        
                $data['branch_name'] =  $this->branch_name;
        
                $data['ifsc_code'] =  $this->ifsc_code;
        
                $data['upi_id'] =  $this->upi_id;
        
                $data['status'] =  $this->status;
        
                $data['type_id'] =  $this->type_id;
        
                $data['created_on'] =  $this->created_on;
        
                $data['updated_on'] =  $this->updated_on;
        
                $data['create_user_id'] =  $this->create_user_id;
        
                $data['update_user_id'] =  $this->update_user_id;
        
            return $data;
}


}



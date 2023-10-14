<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the base model class for table "open_money_linked_contact".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $skipper_id
 * @property string $map_contacts_id
 * @property string $va_account_number
 * @property string $va_ifsc
 * @property string $vpa
 * @property string $commision_type
 * @property string $commision
 * @property integer $status
 * @property integer $created_on
 * @property integer $updated_on
 * @property string $create_user_id
 * @property string $update_user_id
 */
class OpenMoneyLinkedContact extends \yii\db\ActiveRecord
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
            [['user_id', 'skipper_id', 'map_contacts_id', 'va_account_number', 'va_ifsc', 'vpa', 'commision_type', 'commision', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['user_id', 'skipper_id', 'status', 'created_on', 'updated_on'], 'integer'],
            [['create_user_id', 'update_user_id'], 'safe'],
            [['map_contacts_id', 'va_account_number', 'va_ifsc', 'vpa', 'commision_type', 'commision'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'open_money_linked_contact';
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
            'skipper_id' => Yii::t('app', 'Skipper ID'),
            'map_contacts_id' => Yii::t('app', 'Map Contacts ID'),
            'va_account_number' => Yii::t('app', 'Va Account Number'),
            'va_ifsc' => Yii::t('app', 'Va Ifsc'),
            'vpa' => Yii::t('app', 'Vpa'),
            'commision_type' => Yii::t('app', 'Commision Type'),
            'commision' => Yii::t('app', 'Commision'),
            'status' => Yii::t('app', 'Status'),
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
     * @return \app\modules\admin\models\OpenMoneyLinkedContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\OpenMoneyLinkedContactQuery(get_called_class());
    }
public function asJson(){
    $data = [] ; 
            $data['id'] =  $this->id;
        
                $data['user_id'] =  $this->user_id;
        
                $data['skipper_id'] =  $this->skipper_id;
        
                $data['map_contacts_id'] =  $this->map_contacts_id;
        
                $data['va_account_number'] =  $this->va_account_number;
        
                $data['va_ifsc'] =  $this->va_ifsc;
        
                $data['vpa'] =  $this->vpa;
        
                $data['commision_type'] =  $this->commision_type;
        
                $data['commision'] =  $this->commision;
        
                $data['status'] =  $this->status;
        
                $data['created_on'] =  $this->created_on;
        
                $data['updated_on'] =  $this->updated_on;
        
                $data['create_user_id'] =  $this->create_user_id;
        
                $data['update_user_id'] =  $this->update_user_id;
        
            return $data;
}


}



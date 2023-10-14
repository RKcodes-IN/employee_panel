<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the base model class for table "open_money_contacts".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $contacts_id
 * @property string $virtual_account_number
 * @property string $vpa
 * @property string $virtual_account_ifsc
 * @property integer $status
 * @property string $updated_on
 * @property string $created_on
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class OpenMoneyContacts extends \yii\db\ActiveRecord
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
            [['user_id', 'contacts_id', 'virtual_account_number', 'vpa', 'virtual_account_ifsc', 'status', 'updated_on', 'created_on', 'create_user_id', 'update_user_id'], 'required'],
            [['user_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['updated_on', 'created_on'], 'safe'],
            [['contacts_id', 'virtual_account_number', 'vpa', 'virtual_account_ifsc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'open_money_contacts';
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
            'contacts_id' => Yii::t('app', 'Contacts ID'),
            'virtual_account_number' => Yii::t('app', 'Virtual Account Number'),
            'vpa' => Yii::t('app', 'Vpa'),
            'virtual_account_ifsc' => Yii::t('app', 'Virtual Account Ifsc'),
            'status' => Yii::t('app', 'Status'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'created_on' => Yii::t('app', 'Created On'),
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
     * @return \app\modules\admin\models\OpenMoneyContactsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\OpenMoneyContactsQuery(get_called_class());
    }
public function asJson(){
    $data = [] ; 
            $data['id'] =  $this->id;
        
                $data['user_id'] =  $this->user_id;
        
                $data['contacts_id'] =  $this->contacts_id;
        
                $data['virtual_account_number'] =  $this->virtual_account_number;
        
                $data['vpa'] =  $this->vpa;
        
                $data['virtual_account_ifsc'] =  $this->virtual_account_ifsc;
        
                $data['status'] =  $this->status;
        
                $data['updated_on'] =  $this->updated_on;
        
                $data['created_on'] =  $this->created_on;
        
                $data['create_user_id'] =  $this->create_user_id;
        
                $data['update_user_id'] =  $this->update_user_id;
        
            return $data;
}


}



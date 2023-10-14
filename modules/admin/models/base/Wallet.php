<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "wallet".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $amount
 * @property integer $payment_type
 * @property string $method_reason
 * @property integer $type_id
 * @property integer $status
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_user_id
 * @property integer $updated_user_id
 *
 * @property \app\modules\admin\models\User $user
 */
class Wallet extends \yii\db\ActiveRecord
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
    const STATUS_PROCESSING = 3;

    const REFFER_BONUS = 1;
    const NOT_REFFER_BONUS = 2;

    const IS_FEATURED = 1;
    const IS_NOT_FEATURED = 0;

    const STATUS_CREDITED = 1;
    const STATUS_DEBITED = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'payment_type', 'method_reason', 'created_on', 'updated_on', 'created_user_id', 'updated_user_id'], 'required'],
            [['user_id', 'payment_type', 'type_id', 'status', 'created_user_id', 'updated_user_id'], 'integer'],
            [['amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['method_reason'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wallet';
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
        } elseif ($this->status == self::STATUS_DELETE) {
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
        if ($this->type_id == self::IS_FEATURED) {
            return '<span class="badge badge-success">Featured</span>';
        } elseif ($this->type_id == self::IS_NOT_FEATURED) {
            return '<span class="badge badge-danger">Not Featured</span>';
        }
    }

    public function getTypeOptions()
    {
        return [

            self::REFFER_BONUS => 'Refer Bonus',
            self::NOT_REFFER_BONUS => 'Not Refer Bonus',

        ];
    }

    public function getTypeOptionsBadges()
    {
        if ($this->type_id == self::REFFER_BONUS) {
            return '<span class="badge badge-success">Refer Bonus</span>';
        } elseif ($this->type_id == self::NOT_REFFER_BONUS) {
            return '<span class="badge badge-danger">Not Refer Bonus</span>';
        }
    }

    public function getPaymentOptions()
    {
        return [

            self::STATUS_CREDITED => 'Credited',
            self::STATUS_DEBITED => 'Debited',

        ];
    }

    public function getPaymentOptionsBadges()
    {

        if ($this->payment_type == self::STATUS_CREDITED) {
            return '<span class="badge badge-success">Credited</span>';
        } elseif ($this->payment_type == self::STATUS_DEBITED) {
            return '<span class="badge badge-warning">Debited</span>';
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
            'amount' => Yii::t('app', 'Amount'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'method_reason' => Yii::t('app', 'Method Reason'),
            'type_id' => Yii::t('app', 'Type ID'),
            'status' => Yii::t('app', 'Status'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'created_user_id' => Yii::t('app', 'Created User ID'),
            'updated_user_id' => Yii::t('app', 'Updated User ID'),
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
            // 'blameable' => [
            //     'class' => BlameableBehavior::className(),
            //     'createdByAttribute' => 'create_user_id',
            //     'updatedByAttribute' => 'update_user_id',
            // ],
        ];
    }



    /**
     * @inheritdoc
     * @return \app\modules\admin\models\WalletQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\WalletQuery(get_called_class());
    }
    public function asJson()
    {
        $data = [];
        $data['id'] =  $this->id;

        $data['user_id'] =  $this->user_id;

        $data['amount'] =  $this->amount;

        $data['payment_type'] =  $this->payment_type;

        $data['method_reason'] =  $this->method_reason;

        $data['type_id'] =  $this->type_id;

        $data['status'] =  $this->status;

        $data['created_on'] =  $this->created_on;

        $data['updated_on'] =  $this->updated_on;

        $data['created_user_id'] =  $this->created_user_id;

        $data['updated_user_id'] =  $this->updated_user_id;

        return $data;
    }




    public static function getAvailableWallet($id)
    {

        $credit = Wallet::find()->where([
            'status' => Wallet::STATUS_ACTIVE,
            'user_id' => $id,

            'payment_type' => Wallet::STATUS_CREDITED,

        ])->sum('amount');

        $debit = Wallet::find()->where([
            'status' => Wallet::STATUS_ACTIVE,
            'user_id' => $id,
            'payment_type' => Wallet::STATUS_DEBITED,

        ])->sum('amount');
        // var_dump($debit);exit;

        $available_cash = $credit - $debit;
        //    print_r($debit);exit;
        return  round($available_cash, 2);
    }
}

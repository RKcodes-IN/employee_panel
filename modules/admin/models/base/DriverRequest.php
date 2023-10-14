<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "driver_request".
 *
 * @property integer $id
 * @property integer $ride_id
 * @property integer $driver_id
 * @property integer $status
 * @property string $created_on
 * @property string $updated_on
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class DriverRequest extends \yii\db\ActiveRecord
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

    const RIDE_ACCEPT = 1;
    const RIDE_REJECT = 2;
    const RIDE_ASSIGNED = 3;
    const RIDE_CANCELLED = 4;

    const IS_FEATURED = 1;
    const IS_NOT_FEATURED = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ride_id', 'driver_id', 'status', 'created_on', 'updated_on', 'update_user_id'], 'required'],
            [['ride_id', 'driver_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['created_on', 'updated_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver_request';
    }

    public function getStateOptions()
    {
        return [
            self::RIDE_ACCEPT => 'Ride Accept',

            self::RIDE_REJECT => 'Ride Reject',
            self::RIDE_ASSIGNED => 'Ride Assigned',
            self::RIDE_CANCELLED => 'Ride Cancelled',
            // self::STATUS_DELETE => 'Deleted',

        ];
    }
    public function getStateOptionsBadges()
    {

        if ($this->status == self::RIDE_ACCEPT) {
            return '<span class="badge badge-success">Ride Accept</span>';
        } elseif ($this->status == self::RIDE_REJECT) {
            return '<span class="badge badge-warning">In Active</span>';
        }elseif ($this->status == self::RIDE_ASSIGNED) {
            return '<span class="badge badge-warning">Ride Assigned</span>';
        }elseif ($this->status == self::RIDE_CANCELLED) {
            return '<span class="badge badge-warning">Ride Cancelled</span>';
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
            'ride_id' => Yii::t('app', 'Ride ID'),
            'driver_id' => Yii::t('app', 'Driver ID'),
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
     * @return \app\modules\admin\models\DriverRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\DriverRequestQuery(get_called_class());
    }
    public function asJson()
    {
        $data = [];
        $data['id'] =  $this->id;

        $data['ride_id'] =  $this->ride_id;

        $data['driver_id'] =  $this->driver_id;

        $data['status'] =  $this->status;

        $data['created_on'] =  $this->created_on;

        $data['updated_on'] =  $this->updated_on;

        $data['create_user_id'] =  $this->create_user_id;

        $data['update_user_id'] =  $this->update_user_id;

        return $data;
    }
}

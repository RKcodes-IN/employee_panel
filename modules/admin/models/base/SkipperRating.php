<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "skipper_rating".
 *
 * @property integer $id
 * @property integer $skipper_id
 * @property integer $user_id
 * @property integer $ride_id
 * @property double $rating
 * @property integer $status
 * @property string $created_on
 * @property string $updated_on
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * @property \app\modules\admin\models\User $skipper
 * @property \app\modules\admin\models\User $user
 * @property \app\modules\admin\models\RideRequest $ride
 */
class SkipperRating extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames()
    {
        return [
            'skipper',
            'user',
            'ride'
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
            [['skipper_id', 'user_id', 'ride_id', 'rating', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['skipper_id', 'user_id', 'ride_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['rating'], 'number'],
            [['created_on', 'updated_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skipper_rating';
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
            'skipper_id' => Yii::t('app', 'Skipper ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'ride_id' => Yii::t('app', 'Ride ID'),
            'rating' => Yii::t('app', 'Rating'),
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
    public function getSkipper()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'skipper_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRide()
    {
        return $this->hasOne(\app\modules\admin\models\RideRequest::className(), ['id' => 'ride_id']);
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
     * @return \app\modules\admin\models\SkipperRatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\SkipperRatingQuery(get_called_class());
    }
    public function asJson()
    {
        $data = [];
        $data['id'] =  $this->id;

        $data['skipper_id'] =  $this->skipper_id;

        $data['user']['name'] =  $this->user->first_name;

        $data['user']['profile_image'] =  $this->user->profile_image;

        $data['ride_id'] =  $this->ride_id;

        $data['user_discription'] =  $this->user_discription;

        $data['rating'] =  $this->rating;

        $data['status'] =  $this->status;

        $data['created_on'] =  $this->created_on;




        return $data;
    }
    public function asSkipperJson()
    {
        $data = [];
        $data['id'] =  $this->id;

        $data['skipper_id'] =  $this->skipper_id;

        $data['user']['name'] =  $this->user->first_name;
        
        $data['user']['profile_image'] =  $this->user->profile_image;

        $data['ride_id'] =  $this->ride_id;

        $data['rating'] =  $this->rating;

        $data['status'] =  $this->status;

        $data['created_on'] =  $this->created_on;

        return $data;
    }
}

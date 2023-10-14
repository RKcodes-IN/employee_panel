<?php


namespace app\modules\admin\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "fcm_notification".
 *
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property string $description
 * @property string $url
 * @property string $image_url
 * @property integer $status
 * @property string $created_date
 */
class FcmNotification extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    // public function relationNames()
    // {
    //     return [
    //         ''
    //     ];
    // }

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
            [['title', 'user_id', 'description', 'image_url', 'status', 'created_date'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['title', 'description', 'url', 'image_url', 'created_date'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fcm_notification';
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
            'title' => Yii::t('app', 'Title'),
            'user_id' => Yii::t('app', 'User ID'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'image_url' => Yii::t('app', 'Image Url'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    // public function behaviors()
    // {
    //     return [
    //         'timestamp' => [
    //             'class' => TimestampBehavior::className(),
    //             'createdAtAttribute' => 'created_on',
    //             'value' => new \yii\db\Expression('NOW()'),
    //         ],
    //         // 'blameable' => [
    //         //     'class' => BlameableBehavior::className(),
    //         //     'createdByAttribute' => 'create_user_id',
    //         //     'updatedByAttribute' => 'update_user_id',
    //         // ],
    //     ];
    // }



    /**
     * @inheritdoc
     * @return \app\modules\admin\models\FcmNotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\FcmNotificationQuery(get_called_class());
    }
    public function asJson()
    {
        $data = [];
        $data['id'] =  $this->id;

        $data['title'] =  $this->title;

        $data['user_id'] =  $this->user_id;

        $data['description'] =  strip_tags($this->description);

        $data['url'] =  $this->url;

        $data['image_url'] =  $this->image_url;

        $data['status'] =  $this->status;

        $data['created_date'] =  $this->created_date;

        return $data;
    }
}

<?php


namespace app\modules\admin\models\base;

use app\components\AuthSettings;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "coupon".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $discount
 * @property string $max_discount
 * @property double $min_ride_amount
 * @property integer $max_use
 * @property integer $max_use_of_coupon
 * @property string $start_date
 * @property string $end_date
 * @property integer $is_global
 * @property integer $status
 * @property integer $type_id
 * @property string $created_on
 * @property string $updated_on
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * @property \app\modules\admin\models\CouponsApplied[] $couponsApplieds
 */
class Coupon extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames()
    {
        return [
            'couponsApplieds'
        ];
    }

    const FLAT = 1;
    const PERCENTAGE = 2;


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
            [['name', 'code', 'discount', 'max_discount','end_date','start_date'], 'required'],
            [['description'], 'string'],
            [['min_ride_amount'], 'number'],
            [['max_use', 'max_use_of_coupon', 'status', 'type_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['start_date', 'end_date', 'created_on', 'updated_on'], 'safe'],
            [['name', 'code', 'discount', 'max_discount'], 'string', 'max' => 255],
            [['is_global'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
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


    public function getTypeOptions()
    {
        return [

            self::FLAT => 'Flat',
            self::PERCENTAGE => 'Percentage',

        ];
    }

    public function getTypeOptionsBadges()
    {
        if ($this->type == self::FLAT) {
            return '<span class="badge bg-success">Flat</span>';
        } elseif ($this->type == self::PERCENTAGE) {
            return '<span class="badge bg-danger">Percentage</span>';
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'code' => Yii::t('app', 'Code'),
            'discount' => Yii::t('app', 'Discount'),
            'max_discount' => Yii::t('app', 'Max Discount'),
            'min_ride_amount' => Yii::t('app', 'Min Ride Amount'),
            'max_use' => Yii::t('app', 'Max Use'),
            'max_use_of_coupon' => Yii::t('app', 'Max Use Of Coupon'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'is_global' => Yii::t('app', 'Is Global'),
            'status' => Yii::t('app', 'Status'),
            'type_id' => Yii::t('app', 'Type ID'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'create_user_id' => Yii::t('app', 'Create User ID'),
            'update_user_id' => Yii::t('app', 'Update User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouponsApplieds()
    {
        return $this->hasMany(\app\modules\admin\models\CouponsApplied::className(), ['coupon_id' => 'id']);
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
     * @return \app\modules\admin\models\CouponQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\CouponQuery(get_called_class());
    }
    public function asJson()
    {
        $data = [];
        $data['id'] =  $this->id;

        $data['name'] =  $this->name;

        $data['description'] = strip_tags(html_entity_decode($this->description),ENT_QUOTES);

        $data['code'] =  $this->code;

        $data['discount'] =  $this->discount;

        $data['max_discount'] =  $this->max_discount;

        $data['min_ride_amount'] =  $this->min_ride_amount;

        $data['max_use'] =  $this->max_use;

        $data['max_use_of_coupon'] =  $this->max_use_of_coupon;

        $data['start_date'] =  $this->start_date;

        $data['end_date'] =  $this->end_date;

        $data['is_global'] =  $this->is_global;

        $data['status'] =  $this->status;

        $data['type_id'] =  $this->type_id;

        $data['created_on'] =  $this->created_on;

        $data['updated_on'] =  $this->updated_on;

        $data['create_user_id'] =  $this->create_user_id;

        $data['update_user_id'] =  $this->update_user_id;

        return $data;
    }

    // Apply coupon
    public function applyCoupon($coupon_code, $estimated_fare, $user_id)
    {
        $post = Yii::$app->request->post();



        $globalCoupon = Coupon::find()
            ->Where(['status' => Coupon::STATUS_ACTIVE, 'code' => $coupon_code])
            ->one();
        if (empty($globalCoupon)) {
            $data['status'] = "NOK";
            $data['error'] = "Coupon does not exist";
            return $data;
        } else {
            //check for coupon Global or Store wise
            if ($globalCoupon['is_global'] == 1 || $globalCoupon['is_global'] == 0) {
                $coupon = $globalCoupon;
            }
        }
        if ($coupon['min_ride_amount'] <= $estimated_fare) {
            if (!empty($coupon)) {
                // Check User already used or not



                // Check User already used or not
                $check_user_count = CouponsApplied::find()->where([
                    'coupon_id' => $coupon['id'],
                    'create_user_id' => $user_id,
                ])->count();

                $check_coupon_count = CouponsApplied::find()->where(
                    [
                        'coupon_id' => $coupon['id'],
                    ]
                )->count();

                //  echo  $check_user_count->createCommand()->getRawSql();exit;
                //  var_dump( (int)$check_coupon_count < (int)$coupon->max_use_of_coupon);exit;
                $today = Date('Y-m-d');
                if ((int) $check_user_count < (int) $coupon->max_use && (int) $check_coupon_count < (int) $coupon->max_use_of_coupon) {
                    //Apply Discount to Cart
                    //$discount = ($coupon->discount / 100) * $cart->amount;
                    //       if($today >= $coupon['end_date'] && $today <= $coupon['start_date'] ){



                    //Calculate Coupon Discount

                    if ($coupon['type_id'] == Coupon::PERCENTAGE) {
                        $amt = ($coupon['discount'] / 100) * $estimated_fare;
                        if ($amt >= $coupon['max_discount']) {
                            // $voucher_amount = $coupon['max_discount'];
                            $voucher_amount = ($coupon['max_discount'] / 100) * $estimated_fare;
                        } else {
                            $voucher_amount = $amt;
                        }
                    } else {
                        $voucher_amount =  $coupon['max_discount'];
                    }


                    //Update Cart


                    $data['status'] = 'OK';
                    //$data['discount'] = $coupon->max_discount;
                    $data['estimated_fare'] = $estimated_fare - $voucher_amount;
                    // $data['coupon_details'] = $coupon;
                    // }else{
                    //     $data['status'] = self::API_NOK;
                    //     $data['details'] = array("Coupon Expired");
                    // }
                } else {
                    $data['status'] = 'NOK';
                    $data['error'] = "Reached maximum usage of coupon";
                }
            } else {
                $data['status'] = 'NOK';
                $data['error'] = 'This coupon does not work for this store';
            }
        } else {
            $data['status'] = 'NOK';
            $data['error'] = 'For applying coupon your ride value should be ₹' . $coupon['min_ride_amount'];
        }
        // var_dump($data);exit;
        return $data;
    }
}

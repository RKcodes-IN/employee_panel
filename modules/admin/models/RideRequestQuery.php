<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[RideRequest]].
 *
 * @see RideRequest
 */
class RideRequestQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return RideRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RideRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

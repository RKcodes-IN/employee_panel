<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[DriverRequest]].
 *
 * @see DriverRequest
 */
class DriverRequestQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return DriverRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DriverRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

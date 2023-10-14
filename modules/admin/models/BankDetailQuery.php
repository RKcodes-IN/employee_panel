<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[BankDetail]].
 *
 * @see BankDetail
 */
class BankDetailQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return BankDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BankDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

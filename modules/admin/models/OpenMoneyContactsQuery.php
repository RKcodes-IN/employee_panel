<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[OpenMoneyContacts]].
 *
 * @see OpenMoneyContacts
 */
class OpenMoneyContactsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return OpenMoneyContacts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OpenMoneyContacts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

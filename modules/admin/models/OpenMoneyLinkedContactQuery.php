<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[OpenMoneyLinkedContact]].
 *
 * @see OpenMoneyLinkedContact
 */
class OpenMoneyLinkedContactQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return OpenMoneyLinkedContact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OpenMoneyLinkedContact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[SubmittedResume]].
 *
 * @see SubmittedResume
 */
class SubmittedResumeQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SubmittedResume[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SubmittedResume|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Resumes]].
 *
 * @see Resumes
 */
class ResumesQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Resumes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Resumes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

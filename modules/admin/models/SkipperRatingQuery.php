<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[SkipperRating]].
 *
 * @see SkipperRating
 */
class SkipperRatingQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SkipperRating[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SkipperRating|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

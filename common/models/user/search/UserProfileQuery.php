<?php

namespace common\models\user\search;

/**
 * This is the ActiveQuery class for [[\common\models\user\UserProfile]].
 *
 * @see \common\models\user\UserProfile
 */
class UserProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\user\UserProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\user\UserProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

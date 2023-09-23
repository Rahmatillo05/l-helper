<?php

namespace frontend\models;

use common\components\Helper;
use common\models\user\User;
use common\models\user\UserProfile;
use yii\base\Model;

class UserProfileForm extends Model
{
    public $user_id;
    public $bio;
    public $image_id;

    public $social_accounts;
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'image_id'], 'default', 'value' => null],
            [['user_id', 'image_id'], 'integer'],
            [['bio'], 'string'],
            [['social_accounts'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function save(): UserProfile|array|null
    {
        if ($this->validate()){
            $user_profile  = UserProfile::findOne(['user_id' => $this->user_id]);
            if (!$user_profile){
                $user_profile = new UserProfile();
                $user_profile->user_id = $this->user_id;
            }
            $user_profile->bio = $this->bio;
            $user_profile->image_id = $this->image_id;
            $user_profile->social_accounts = $this->social_accounts;
            if ($user_profile->save()){
                return $user_profile;
            }
            return $user_profile->errors;
        }
        return $this->errors;
    }
}
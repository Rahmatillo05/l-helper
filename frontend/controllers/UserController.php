<?php

namespace frontend\controllers;

use common\components\Detect;
use common\models\user\User;
use frontend\models\UserProfileForm;
use yii\web\MethodNotAllowedHttpException;

class UserController extends BaseController
{
    public $modelClass = User::class;

    public function actions(): void
    {
        $actions = parent::actions();
        unset($actions);
    }

    /**
     * @throws MethodNotAllowedHttpException
     */
    public function actionUserDetails(int $user_type)
    {
        $profile = null;
        if ($this->request->isPost) {
            if ($user_type == Detect::COMMON_USER) {
                $profile = new UserProfileForm();
                if ($profile->load($this->request->post(), '')) {
                    return $profile->save();
                }
            }
            return $profile;
        }
        throw new MethodNotAllowedHttpException();
    }
}
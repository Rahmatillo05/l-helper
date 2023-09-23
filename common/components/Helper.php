<?php

namespace common\components;

use yii\helpers\Json;

class Helper
{
    public static function isEmail(string $verification): ?string
    {
        if (filter_var($verification, FILTER_VALIDATE_EMAIL)) {
            return $verification;
        }
        return null;
    }

    public static function isPhoneNumber(string $verification): ?string
    {
        if (preg_match('/^998\d{9}$/', $verification)) {
            return $verification;
        }
        return null;
    }

    public static function jsonEncode( $data): string|null
    {
        if ($data) {
            return Json::encode($data);
        }
        return null;
    }

}
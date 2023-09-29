<?php

namespace frontend\controllers;

use common\models\members\Member;

class MemberController extends BaseController
{
    public $modelClass = Member::class;
}
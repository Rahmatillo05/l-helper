<?php

namespace frontend\modules\file;

use yii\rest\UrlRule;

/**
 * file-manager module definition class
 */
class FileManager extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\file\controllers';

    public $defaultRoute = 'file';
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}

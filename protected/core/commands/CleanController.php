<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\commands;

use yii\console\Controller;
use core\modules\file\models\File;

class CleanController extends Controller
{
    /**
     * Clean unused images.
     */
    public function actionIndex()
    {
        $files = File::find()->where(['object_id' => ''])->all();
        foreach ($files as $file) {
            $file->delete();
        }
    }
}

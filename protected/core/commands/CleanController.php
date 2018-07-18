<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\commands;

use Yii;
use yii\console\Controller;
use core\modules\file\models\File;

class CleanController extends Controller
{
    /**
     * Clean unused images.
     */
    public function actionIndex()
    {
        //Delete file not used in database
        $folder = $main_path = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR
            . "uploads" . DIRECTORY_SEPARATOR . 'file';

        $files = File::find()->where(['object_id' => ''])->all();
        foreach ($files as $file) {
            $file->delete();
            echo 'Remove folder: ' . $folder . DIRECTORY_SEPARATOR . $file->guid, PHP_EOL;
        }

        if (is_dir($folder)) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if ($file == '.' || $file == '..') continue;
                $exist = File::find()->where(['guid' => $file])->count();
                if (!$exist) {
                    $f = $folder . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($f)) {
                        $_f = glob($f . DIRECTORY_SEPARATOR . '*');
                        foreach ($_f as $item) {
                            if (is_file($item)) {
                                unlink($item);
                            }
                        }
                    }
                    rmdir($f);
                    echo "Remove folder: " . $f, PHP_EOL;
                }
            }
        }
    }
}

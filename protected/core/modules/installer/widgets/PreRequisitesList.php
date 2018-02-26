<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\modules\installer\widgets;

use core\libs\SelfTest;

/**
 * PrerequisitesList widget shows all current prerequisites
 */
class PreRequisitesList extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('pre-requisites-list', ['checks' => SelfTest::getResults()]);
    }

    /**
     * Check there is an error
     *
     * @return boolean
     */
    public static function hasError()
    {
        foreach (SelfTest::getResults() as $check) {
            if ($check['state'] == 'ERROR') {
                return true;
            }
        }

        return false;
    }

}

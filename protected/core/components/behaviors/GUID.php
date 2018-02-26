<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
 * GUID Behavior
 */
class GUID extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setGuid',
            ActiveRecord::EVENT_BEFORE_INSERT => 'setGuid',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setGuid',
        ];
    }

    public function setGuid($event) {
        if ($this->owner->isNewRecord) {
            if ($this->owner->guid == "") {
                $this->owner->guid = \core\libs\UUID::v4();
            }
        }
    }
}

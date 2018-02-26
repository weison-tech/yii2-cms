<?php
/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\libs;

use yii\base\Exception;

/**
 * This class contains a lot of html helpers for the views
 *
 * @since 0.5
 */
class Helpers
{
    /**
     * Checks if the class has this class as one of its parents
     *
     * @param string $className
     * @param string $type
     * @return boolean
     * @throws
     */
    public static function CheckClassType($className, $type = '')
    {
        $className = preg_replace('/[^a-z0-9_\-\\\]/i', '', $className);
        if (is_array($type)) {
            foreach ($type as $t) {
                if (class_exists($className) && is_subclass_of($className, $t)) {
                    return true;
                }
            }
        } else {
            if (class_exists($className) && is_subclass_of($className, $type)) {
                return true;
            }
        }
        throw new Exception("Invalid class type! (" . $className . ")");
    }
}

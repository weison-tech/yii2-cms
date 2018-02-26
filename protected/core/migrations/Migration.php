<?php

/*
 * This file is part of the Shop project.
 *
 * (c) Shop project <https://github.com/weison-tech/shop>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace core\migrations;

use Yii;
/**
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class Migration extends \yii\db\Migration
{
    /**
     * @var string
     */
    protected $tableOptions;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        switch (Yii::$app->db->driverName) {
            case 'mysql':
                $this->tableOptions = "ENGINE=InnoDB DEFAULT CHARSET=utf8";
                break;
            case 'pgsql':
                $this->tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
    }
}

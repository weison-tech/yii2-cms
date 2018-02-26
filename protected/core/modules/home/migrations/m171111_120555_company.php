<?php

use core\migrations\Migration;

class m171111_120555_company extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey()->unsigned()->comment('id'),
            'name' => $this->string(90)->notNull()->comment('名称'),
            'en_name' => $this->string(90)->notNull()->comment('英文名'),
            'description' => $this->text()->comment('简介'),
            'address' => $this->string(255)->notNull()->comment('地址'),
            'latitude' => $this->string(32)->notNull()->comment('纬度'),
            'longitude' => $this->string(32)->notNull()->comment('经度'),
            'mobile' => $this->string(16)->notNull()->comment('电话'),
            'email' => $this->string(64)->notNull()->comment('邮箱'),
        ], $this->tableOptions);
    }

    public function safeDown()
    {
        echo "m171111_120555_company cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171111_120555_company cannot be reverted.\n";

        return false;
    }
    */
}

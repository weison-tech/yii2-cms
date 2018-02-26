<?php

use core\migrations\Migration;

class m171111_121211_contact extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey()->unsigned()->comment('id'),
            'name' => $this->string(90)->notNull()->comment('名称'),
            'company' => $this->string(90)->notNull()->comment('公司名'),
            'mobile' => $this->string(16)->notNull()->comment('电话'),
            'email' => $this->string(64)->notNull()->comment('邮箱'),
            'demand' => $this->text()->comment('需求'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('创建时间'),
            'status' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)->comment('状态：0未处理; 1已处理; 2删除'),
        ], $this->tableOptions);
    }

    public function safeDown()
    {
        echo "m171111_121211_contact cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171111_121211_contact cannot be reverted.\n";

        return false;
    }
    */
}

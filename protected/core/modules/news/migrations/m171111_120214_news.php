<?php

use core\migrations\Migration;

class m171111_120214_news extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey()->unsigned()->comment('新闻ID'),
            'category_id' => $this->integer()->unsigned()->notNull()->comment('分类ID'),
            'title' => $this->string(120)->notNull()->comment('新闻标题'),
            'summary' => $this->string(255)->notNull()->comment('新闻摘要'),
            'content' => $this->text()->comment('新闻内容'),
            'sort_order' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('排序'),
            'status' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(1)->comment('状态：0隐藏; 1展示; 2删除'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('创建时间'),
            'created_by' => $this->integer()->unsigned()->notNull()->comment('创建人'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('更新时间'),
            'updated_by' => $this->integer()->unsigned()->notNull()->comment('更新人'),
        ], $this->tableOptions);
    }

    public function safeDown()
    {
        echo "m171111_120214_news cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171111_120214_news cannot be reverted.\n";

        return false;
    }
    */
}

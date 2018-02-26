<?php

use core\migrations\Migration;

class m161222_060937_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned()->comment('分类id'),
            'type' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)->comment('类型 0产品分类;1行业分类;2新闻分类3服务分类'),
            'name' => $this->string(90)->notNull()->comment('分类名称'),
            'parent_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('父类id'),
            'sort_order' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('排序'),
            'status' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(1)->comment('状态：0隐藏; 1展示; 2删除'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('创建时间'),
            'created_by' => $this->integer()->unsigned()->notNull()->comment('创建人'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('更新时间'),
            'updated_by' => $this->integer()->unsigned()->notNull()->comment('更新人'),
        ], $this->tableOptions);
    }

    public function down()
    {
        echo "m161222_060937_category cannot be reverted.\n";

        return false;
    }
}

<?php

use core\migrations\Migration;

class m161222_060507_products extends Migration
{
    public function up()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey()->unsigned()->comment('产品ID'),
            'category_id' => $this->integer()->unsigned()->notNull()->comment('分类ID'),
            'industry_id' => $this->integer()->unsigned()->notNull()->comment('行业ID'),
            'name' => $this->string(120)->notNull()->comment('产品名称'),
            'title' => $this->string(255)->notNull()->comment('产品标题'),
            'description' => $this->text()->comment('详细描述'),
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
        echo "m161222_060507_products cannot be reverted.\n";

        return false;
    }
}

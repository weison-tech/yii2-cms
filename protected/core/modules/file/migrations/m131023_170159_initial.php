<?php

use core\migrations\Migration;

class m131023_170159_initial extends Migration
{

    public function up()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey()->comment('文件ID'),
            'guid' => $this->string(45)->defaultValue('')->comment('全球唯一标识'),
            'object_model' => $this->string(100)->notNull()->defaultValue('')->comment('对象模型类'),
            'object_id' => $this->string(100)->notNull()->defaultValue('')->comment('对象ID'),
            'object_field' => $this->string(32)->notNull()->defaultValue('')->comment('对象字段'),
            'file_name' => $this->string()->defaultValue('')->comment('文件名'),
            'title' => $this->string()->defaultValue('')->comment('显示标题'),
            'mime_type' => $this->string(100)->defaultValue('')->comment('文件类型'),
            'size' => $this->string(45)->defaultValue('')->comment('大小'),
            'sort' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('排序'),
            'created_at' => $this->integer()->unsigned()->defaultValue(0)->comment('创建时间'),
            'created_by' => $this->integer()->unsigned()->defaultValue(0)->comment('创建人'),
            'updated_at' => $this->integer()->unsigned()->defaultValue(0)->comment('修改时间'),
            'updated_by' => $this->integer()->unsigned()->defaultValue(0)->comment('修改人'),
        ], $this->tableOptions);

        //Add index
        $this->createIndex('index_object', '{{%file}}', 'object_model, object_id', false);

        //Initial basic setting
        Yii::$app->getModule('file')->settings->set('maxFileSize', 4 * 1024 * 1024);
        Yii::$app->getModule('file')->settings->set('allowedExtensions', 'jpg,png,gif');
    }

    public function down()
    {
        echo "m131023_170159_initial does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}

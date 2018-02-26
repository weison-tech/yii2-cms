<?php

use core\migrations\Migration;
use core\modules\user\models\User;

class m131023_165755_initial extends Migration
{

    public function up()
    {
        //Create setting table.
        $this->createTable('setting', array(
            'id' => 'pk',
            'name' => 'varchar(100) NOT NULL',
            'value' => 'varchar(255) NOT NULL',
            'module_id' => 'varchar(100) DEFAULT NULL',
                ), '');

        //Create enabled module table.
        $this->createTable('module_enabled', array(
            'module_id' => 'varchar(100) NOT NULL',
                ), '');
        $this->addPrimaryKey('pk_module_enabled', 'module_enabled', 'module_id');

        //Create admin user table
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->tableOptions);
    }

    public function down()
    {
        echo "m131023_165755_initial does not support migration down.\n";
        return false;
    }
}

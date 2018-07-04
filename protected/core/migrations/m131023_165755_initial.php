<?php

use core\migrations\Migration;
use core\modules\user\models\User;
use core\modules\admin\models\Admin;

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
            'status' => $this->smallInteger()->notNull()->defaultValue(Admin::STATUS_ACTIVE),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->tableOptions);

        //Create frontend user table
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer()
        ], $this->tableOptions);

        //Create front user profile table.
        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'nickname' => $this->string(),
            'avatar' => $this->string(),
            'gender' => $this->smallInteger(1)
        ], $this->tableOptions);
        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        echo "m131023_165755_initial does not support migration down.\n";
        return false;
    }
}

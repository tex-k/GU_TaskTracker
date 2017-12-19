<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m171015_125215_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(30)->notNull()->unique(),
            'password' => $this->string(200)->notNull(),
            'email' => $this->string(45)->notNull()->unique(),
            'name' => $this->string(15),
            'status' => $this->string(10)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}

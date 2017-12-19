<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m171215_133853_create_task_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'name' =>$this->string(255),
            'description' => $this->text(),
            'fk_adm_id' => $this->integer(11),
            'created_at' => $this->integer(11),
            'deadline' => $this->integer(11),
            'report' => $this->text(),
            'done' => $this->string(15),
            'done_at' => $this->integer(11),
            'fk_team_id' => $this->integer(11)->notNull(),
            'fk_user_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_teams_id', 'task', 'fk_team_id', 'teams', 'id');
        $this->addForeignKey('fk_users_id', 'task', 'fk_user_id', 'user', 'id');
        $this->addForeignKey('fk_adms_id', 'task', 'fk_adm_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_teams_id', 'task');
        $this->dropForeignKey('fk_users_id', 'task');
        $this->dropForeignKey('fk_adms_id', 'task');
        $this->dropTable('task');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_team`.
 */
class m171204_110223_create_user_team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_team', [
            'id' => $this->primaryKey(),
            'fk_team_id' => $this->integer(11)->notNull(),
            'fk_user_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_team_id', 'user_team', 'fk_team_id', 'teams', 'id');
        $this->addForeignKey('fk_user_id', 'user_team', 'fk_user_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_team_id', 'user_team');
        $this->dropForeignKey('fk_user_id', 'user_team');
        $this->dropTable('user_team');
    }
}

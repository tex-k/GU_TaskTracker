<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teams`.
 */
class m171204_094255_create_teams_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teams', [
            'id' => $this->primaryKey(),
            'name' => $this->string(15),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('teams');
    }
}

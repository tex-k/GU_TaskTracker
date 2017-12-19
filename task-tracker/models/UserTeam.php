<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class UserTeam extends ActiveRecord
{
    public $name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_team_id'], 'integer', 'max' => 255],
            [['fk_user_id'], 'integer', 'max' => 255],
        ];
    }

    public static function isCurrentUserInTeam($team_id) {
        $records = \app\models\UserTeam::find()->all();
        foreach ($records as $record):
            if (($record->fk_team_id == $team_id) && ($record->fk_user_id == Yii::$app->user->id)) {
                return true;
            }
        endforeach;
        return false;
    }

    /**
     * @inheritdoc
     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'name' => 'Название команды',
//        ];
//    }
}
<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $date
 * @property string $description
 * @property integer $fk_user_id
 * @property integer $updated_at
 *
 * @property User $fkUser
 */
class Task extends ActiveRecord
{

    public $events = []; //События, сгруппированные по дням
    public $date_event; //Дата

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'fk_adm_id', 'deadline', 'fk_team_id', 'fk_user_id'], 'required'],
            [['fk_team_id', 'fk_user_id', 'created_at', 'deadline', 'done_at', 'fk_adm_id'], 'integer'],
            [['name', 'done'], 'string', 'max' => 255],
            [['description', 'report'], 'string'],
            [['fk_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::className(), 'targetAttribute' => ['fk_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'fk_adm_id' => 'Администратор',
            'fk_team_id' => 'Команда',
            'fk_user_id' => 'Исполнитель',
            'created_at' => 'Создана',
            'deadline' => 'Выполнить до',
            'report' => 'Отчёт',
            'done' => 'Результат',
            'done_at' => 'Дата выполнения'
        ];
    }
}

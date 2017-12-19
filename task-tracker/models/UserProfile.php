<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class UserProfile extends ActiveRecord implements IdentityInterface {

    public $authKey;

    // Связь с БД
    public static function tableName()
    {
        return 'user';
    }

//    public function behaviors()
//    {
//        return [
//            'timestamp' => [
//                'class' => TimestampBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
//                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
//                ]
//            ]
//        ];
//    }

    // Правила валидации
    public function rules()
    {
        return [
            [['login', 'password', 'email', 'status'], 'required'],
            [['login', 'email'], 'unique'],
            [['login'], 'string', 'max'=>30],
            [['password'], 'string', 'max'=>200],
            [['email'], 'string', 'max'=>45],
            [['email'], 'email'],
            [['name', 'status'], 'string', 'max'=>15]
        ];
    }

    // Подписи для формы
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Адрес электронной почты',
            'name' => 'Имя',
            'status' => 'Статус'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['fk_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['fk_user_id' => 'id']);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Не поддерживает AccessToken');
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     * @throws NotSupportedException
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     * @throws NotSupportedException
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password) {
        return $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function beforeSave($insert)
    {
        $this->password = $this->setPassword($this->password);
        return parent::beforeSave($insert);
    }

    public function findByUsername($login) {
        return static::findOne(['login' => $login]);
    }

    public static function getCurrentStatus() {
        if (!Yii::$app->user->isGuest) {
            $users = self::find()->all();
            foreach ($users as $user):
                if ($user->id == Yii::$app->user->id) {
                    return $user->status;
                }
            endforeach;
        }
        return '';
    }
}
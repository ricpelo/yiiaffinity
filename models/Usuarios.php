<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login'], 'required'],
            [['login'], 'string', 'max' => 50],
            [['login'], 'unique'],
            [['password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['password'], 'compare', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null|mixed $type
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                goto salto;
            }
        } elseif ($this->scenario === self::SCENARIO_UPDATE) {
            if ($this->password === '') {
                $this->password = $this->getOldAttribute('password');
            } else {
                salto:
                $this->password = Yii::$app->security
                    ->generatePasswordHash($this->password);
            }
        }

        return true;
    }
}

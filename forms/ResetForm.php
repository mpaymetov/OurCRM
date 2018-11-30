<?php

namespace app\forms;

use Yii;
use yii\base\Model;
use app\controllers\SecurityController;
use app\models\user;
use app\service\UserService;

/**
 * Signup form
 */
class ResetForm extends Model
{

    public $login;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 3],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function reset()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = User::findByLogin($this->login);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;

    }

}
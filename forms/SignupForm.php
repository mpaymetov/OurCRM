<?php

namespace app\forms;

use Yii;
use yii\base\Model;
use app\controllers\SecurityController;
use app\models\user;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $login;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This login has already been taken.'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 3],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->version = 0;

        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('baserole');
            $auth->assign($authorRole, $user->getId());
            return $user;
        } else {
            return null;
        }
    }

}
<?php

namespace app\forms;

use Yii;
use yii\base\Model;
use app\controllers\SecurityController;
use app\models\User;
use app\service\UserService;

/**
 * Signup form
 */
class ViewForm extends Model
{
    public $id;
    public $login;
    public $first_name;
    public $second_name;
    public $id_department;
    public $status;
    public $email;
    public $created_at;
    public $updated_at;
    public $role;

    public function rules()
    {
        return [
            ['id', 'trim'],
            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This login has already been taken.'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['first_name', 'required'],
            ['second_name', 'required'],
            ['id_department', 'required'],
            ['role', 'trim'],
            ['role', 'required'],
            ['role', 'string'],
            ['status', 'trim'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = User::findModel($this->id);
        $user->login = $this->login;
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->second_name = $this->second_name;
        $user->id_department = (int)$this->id_department;
        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $auth->removeAll($user->id_user);
            $authorRole = $auth->getRole($this->role);
            $auth->assign($authorRole, $user->getId());
            return $user;
        } else {
            return null;
        }
    }

    public function getDepartments()
    {
        return $this->hasOne(Department::className(), ['id_department' => 'id_department']);
    }
}
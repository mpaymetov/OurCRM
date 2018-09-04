<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property string $id_role
 * @property string $name
 * @property int $is_admin
 * @property int $user_read_all
 * @property int $user_self_dep
 * @property int $user_create
 * @property int $client_read_all
 * @property int $client_create
 * @property int $project_read_all
 * @property int $project_create
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'is_admin', 'user_read_all', 'user_self_dep'], 'required'],
            [['is_admin', 'user_read_all', 'user_self_dep', 'user_create', 'client_read_all', 'client_create', 'project_read_all', 'project_create'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_role' => Yii::t('app', 'Id Role'),
            'name' => Yii::t('app', 'Name'),
            'is_admin' => Yii::t('app', 'Is Admin'),
            'user_read_all' => Yii::t('app', 'User Read All'),
            'user_self_dep' => Yii::t('app', 'User Self Dep'),
            'user_create' => Yii::t('app', 'User Create'),
            'client_read_all' => Yii::t('app', 'Client Read All'),
            'client_create' => Yii::t('app', 'Client Create'),
            'project_read_all' => Yii::t('app', 'Project Read All'),
            'project_create' => Yii::t('app', 'Project Create'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_role' => 'id_role']);
    }
}

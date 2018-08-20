<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property string $id_project
 * @property string $name
 * @property string $id_client
 * @property string id_user
 * @property string $comment
 * @property int $is_active
 *
 * @property Client $client
 * @property User $user
 * @property Serviceset[] $servicesets
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_client', 'id_user', 'comment'], 'required'],
            [['id_client', 'id_user', 'is_active'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['id_client' => 'id_client']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_project' => 'Id Project',
            'name' => 'Name',
            'id_client' => 'Id Client',
            'id_user' => 'Id Manager',
            'comment' => 'Comment',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id_client' => 'id_client']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id_user' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicesets()
    {
        return $this->hasMany(Serviceset::className(), ['id_project' => 'id_project']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property string $id_client
 * @property string $name
 * @property string $created
 * @property string $comment
 * @property string $id_manager
 *
 * @property Manager $manager
 * @property Project[] $projects
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'comment', 'id_manager'], 'required'],
            [['created'], 'safe'],
            [['comment'], 'string'],
            [['id_manager'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_manager'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['id_manager' => 'id_manager']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_client' => 'Id Client',
            'name' => 'Name',
            'created' => 'Created',
            'comment' => 'Comment',
            'id_manager' => 'Id Manager',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['id_manager' => 'id_manager']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id_client' => 'id_client']);
    }

    public function create()
    {
        Client::actionCreate();
    }
}

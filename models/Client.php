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
 * @property string $id_user
 *
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
            [['name', 'comment', 'id_user'], 'required'],
            [['created'], 'safe'],
            [['comment'], 'string'],
            [['id_user'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_client' => Yii::t('app', 'Id Client'),
            'name' => Yii::t('app', 'Name'),
            'created' => Yii::t('app', 'Created'),
            'comment' => Yii::t('app', 'Comment'),
            'id_user' => Yii::t('app', 'Id User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id_client' => 'id_client']);
    }
}

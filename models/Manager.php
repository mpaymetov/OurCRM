<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manager".
 *
 * @property string $id_manager
 * @property string $name
 * @property string $id_department
 *
 * @property Client[] $clients
 * @property Department $department
 * @property Project[] $projects
 */
class Manager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_department'], 'required'],
            [['id_department'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_department'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['id_department' => 'id_department']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_manager' => 'Id Manager',
            'name' => 'Name',
            'id_department' => 'Id Department',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['id_manager' => 'id_manager']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id_department' => 'id_department']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id_manager' => 'id_manager']);
    }
}

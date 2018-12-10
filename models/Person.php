<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 07.12.2018
 * Time: 20:46
 */

namespace app\models;

use yii;



class Person extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'person';
    }

    public function optimisticLock()
    {
        return 'version';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact'], 'required'],
            [['first_name', 'last_name', 'position', 'contact'], 'string'],
            [['email'], 'email'],
            [['first_name', 'last_name', 'position', 'email'], 'default', 'value' => null],
            [['id_person'], 'integer'],
            [['main', 'last_main'], 'default', 'value' => 0],
            [['version'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_person' => Yii::t('common', 'Id person'),
            'first_name' => Yii::t('common', 'First Name'),
            'last_name' => Yii::t('common', 'Last Name'),
            'position' => Yii::t('common', 'Position'),
            'contact' => Yii::t('common', 'Contact'),
            'email' => 'E-mail',
            'version' => Yii::t('common', 'Version'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id_client' => 'id_client']);
    }*/

}
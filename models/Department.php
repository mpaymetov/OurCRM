<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property string $id_department
 * @property string $name
 *
 * @property Manager[] $managers
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['version'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_department' => Yii::t('common', 'Id Department'),
            'name' => Yii::t('common', 'Name'),
        ];
    }
}

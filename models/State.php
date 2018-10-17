<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property string $id_state
 * @property string $name
 *
 * @property Serviceset[] $servicesets
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state';
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
            [['name'], 'string', 'max' => 20],
            [['version'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_state' => Yii::t('common', 'Id State'),
            'name' => Yii::t('common', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicesets()
    {
        return $this->hasMany(Serviceset::className(), ['id_state' => 'id_state']);
    }
}

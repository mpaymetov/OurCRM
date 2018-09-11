<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property string $id_service
 * @property string $name
 * @property string $description
 * @property double $cost
 * @property int $is_enable
 *
 * @property Servicelist[] $servicelists
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
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
            [['name', 'description'], 'required'],
            [['cost'], 'number'],
            [['is_enable'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['version'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_service' =>  Yii::t('common', 'Id Service'),
            'name' =>  Yii::t('common', 'Name'),
            'description' =>  Yii::t('common', 'Description'),
            'cost' =>  Yii::t('common', 'Cost'),
            'is_enable' =>  Yii::t('common', 'Is Enable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicelists()
    {
        return $this->hasMany(Servicelist::className(), ['id_service' => 'id_service']);
    }
}

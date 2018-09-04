<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicelist".
 *
 * @property string $id_servicelist
 * @property string $id_serviceset
 * @property string $id_service
 *
 * @property Service $service
 * @property Serviceset $serviceset
 */
class Servicelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_serviceset', 'id_service'], 'required'],
            [['id_serviceset', 'id_service'], 'integer'],
            [['id_service'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['id_service' => 'id_service']],
            [['id_serviceset'], 'exist', 'skipOnError' => true, 'targetClass' => Serviceset::className(), 'targetAttribute' => ['id_serviceset' => 'id_serviceset']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_servicelist' => 'Id Servicelist',
            'id_serviceset' => 'Id Serviceset',
            'id_service' => 'Id Service',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id_service' => 'id_service']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceset()
    {
        return $this->hasOne(Serviceset::className(), ['id_serviceset' => 'id_serviceset']);
    }

    public function saveServiceList($data)
    {
        $this->id_serviceset = $data['id_serviceset'];
        $this->id_service = $data['id_service'];
        return $this->save();
    }
}

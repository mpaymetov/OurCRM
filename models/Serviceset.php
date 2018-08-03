<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "serviceset".
 *
 * @property string $id_serviceset
 * @property string $id_project
 * @property string $id_state
 * @property string $delivery
 * @property string $payment
 *
 * @property Servicelist[] $servicelists
 * @property Project $project
 * @property State $state
 */
class Serviceset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'serviceset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_project', 'id_state', 'delivery', 'payment'], 'required'],
            [['id_project', 'id_state'], 'integer'],
            [['delivery', 'payment'], 'safe'],
            [['id_project'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['id_project' => 'id_project']],
            [['id_state'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['id_state' => 'id_state']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_serviceset' => 'Id Serviceset',
            'id_project' => 'Id Project',
            'id_state' => 'Id State',
            'delivery' => 'Delivery',
            'payment' => 'Payment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicelists()
    {
        return $this->hasMany(Servicelist::className(), ['id_serviceset' => 'id_serviceset']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id_project' => 'id_project']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id_state' => 'id_state']);
    }
}

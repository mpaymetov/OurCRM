<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property string $id_event
 * @property string $message
 * @property string $created
 * @property string $assignment
 * @property int $link
 * @property string $id_link
 * @property string $id_user
 * @property int $is_active
 *
 * @property User $user
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
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
            [['message', 'id_user'], 'required'],
            [['created', 'assignment'], 'safe'],
            [['link', 'id_link', 'id_user', 'is_active'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id_user']],
            [['version'], 'integer'],
            [['id_doer'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_event' => Yii::t('common', 'Id Event'),
            'message' => Yii::t('common', 'Message'),
            'created' => Yii::t('common', 'Created'),
            'assignment' => Yii::t('common', 'Assignment'),
            'link' => Yii::t('common', 'Link'),
            'id_link' => Yii::t('common', 'Id Link'),
            'id_user' => Yii::t('common', 'Id User'),
            'is_active' => Yii::t('common', 'Is Active'),
            'id_doer' => Yii::t('common', 'Doer'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id_user' => 'id_user']);
    }



    public static function getArrOfDoer()
    {
        $arrModels = UserSearch::find();
        return $arrModels;
    }
}

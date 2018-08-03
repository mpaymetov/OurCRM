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
 * @property string $id_manager
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'id_manager'], 'required'],
            [['created', 'assignment'], 'safe'],
            [['link', 'id_link', 'id_manager'], 'integer'],
            [['message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_event' => 'Id Event',
            'message' => 'Message',
            'created' => 'Created',
            'assignment' => 'Assignment',
            'link' => 'Link',
            'id_link' => 'Id Link',
            'id_manager' => 'Id Manager',
        ];
    }
}

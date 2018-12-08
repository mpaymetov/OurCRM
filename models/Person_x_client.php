<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.12.2018
 * Time: 14:39
 */

namespace app\models;

use yii;


class Person_x_client extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'person_x_client';
    }

    public function rules()
    {
        return [
            [['id_person', 'id_client'], 'integer'],
            [['id_person', 'id_client'], 'required']
        ];
    }

}
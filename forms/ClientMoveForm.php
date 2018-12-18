<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 17.12.2018
 * Time: 20:17
 */

namespace app\forms;

use Yii;
use yii\base\Model;

class ClientMoveForm extends Model
{
    public $idClient;
    public $idManager;

    public function rules()
    {
        return [
            [['idClient', 'idManager'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'idClient' => Yii::t('common', 'Client'),
            'idManager' => Yii::t('common', 'Manager')
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 20.11.2018
 * Time: 19:37
 */

namespace app\db_modules;


class statisticDbQuery
{
    public function getServicesetNumByState($idUser)
    {
        $query = (new \yii\db\Query())
            ->select([
                'serviceset.id_state AS state',
                'COUNT(*) AS num'
            ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->where(['project.id_user' => $idUser])
            ->andWhere(['<', 'serviceset.id_state', '5'])
            ->groupBy('serviceset.id_state')
            ->all();

        return $query;
    }

    //данные за текущий год по менеджеру(количество созданных и закрытых проектов )
    public function getProjectNumberForLastYear($idUser)
    {
        /*$expression = new Expression('COUNT(*) AS num,
            SUM(serviceset.id_state=5) AS close,
            SUM(serviceset.id_state=6) AS cancellation');
        $query = (new \yii\db\Query())
            ->select([
                new \yii\db\Expression('COUNT(*) AS num'),
                new \yii\db\Expression('SUM(serviceset.id_state=5) AS close'),
                new \yii\db\Expression('SUM(serviceset.id_state=6) AS cancellation')
                ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->where(['=', 'project.id_user', $idUser])
            ->andWhere(['>', 'project.creation_date', 'LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))'])
            ->andWhere(['<', 'project.creation_date', 'DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY) '])
            ->groupBy('MONTH(project.creation_date)')
            ->all();*/

        $query = \Yii::$app->db->createCommand(
            'SELECT
	        MONTHNAME(project.creation_date) AS month,
	        COUNT(*) AS num,
            SUM(serviceset.id_state=5) AS close,
            SUM(serviceset.id_state=6) AS cancellation
            from serviceset
            left Join project on project.id_project=serviceset.id_project
            where project.id_user = :id_user and 
	        project.creation_date > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) and
	        project.creation_date < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)
            group By MONTH(project.creation_date)')
            ->bindValue(':id_user', $idUser)
            ->queryAll();
        return $query;
    }

    public function getProjectNumberForPeriod($idUser, $from, $to)
    {
        /*$expression = new Expression('COUNT(*) AS num,
            SUM(serviceset.id_state=5) AS close,
            SUM(serviceset.id_state=6) AS cancellation');
        $query = (new \yii\db\Query())
            ->select([
                new \yii\db\Expression('COUNT(*) AS num'),
                new \yii\db\Expression('SUM(serviceset.id_state=5) AS close'),
                new \yii\db\Expression('SUM(serviceset.id_state=6) AS cancellation')
                ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->where(['=', 'project.id_user', $idUser])
            ->andWhere(['>', 'project.creation_date', 'LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))'])
            ->andWhere(['<', 'project.creation_date', 'DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY) '])
            ->groupBy('MONTH(project.creation_date)')
            ->all();*/

        $query = \Yii::$app->db->createCommand(
            'SELECT
	        MONTHNAME(project.creation_date) AS month,
	        COUNT(*) AS num,
            SUM(serviceset.id_state=5) AS close,
            SUM(serviceset.id_state=6) AS cancellation
            from serviceset
            left Join project on project.id_project=serviceset.id_project
            where project.id_user = :id_user and 
	        project.creation_date >= :first_date and
	        project.creation_date <= :last_date
            group By MONTH(project.creation_date)')
            ->bindValue(':id_user', $idUser)
            ->bindValue(':first_date', $from)
            ->bindValue(':last_date', $to)
            ->queryAll();
        return $query;
    }



    //Сумма продаж по месяцам за последний год
    public function getSalesForLastYear($idUser)
    {
        /*$query = (new \yii\db\Query())
            ->select([
                'MONTH(serviceset.close_date) AS month',
                'SUM(service.cost) AS cost',
            ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->leftJoin('servicelist', 'servicelist.id_serviceset=serviceset.id_serviceset')
            ->leftJoin('service', 'service.id_service=servicelist.id_service')
            ->where([
                'serviceset.id_state' => 5,
                'project.id_user' => $idUser,
            ])
            ->andWhere(['>', 'serviceset.close_date', 'LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))'])
            ->andWhere(['<', 'serviceset.close_date', 'DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)'])
            ->groupBy('MONTH(project.creation_date)')
            ->all();*/
        $query = \Yii::$app->db->createCommand(
            'select
	        MONTHNAME(serviceset.close_date) AS month,
            SUM(service.cost) AS cost
            from serviceset
            left Join project on project.id_project=serviceset.id_project
            left Join servicelist on servicelist.id_serviceset=serviceset.id_serviceset
            left Join service on service.id_service=servicelist.id_service
            where serviceset.id_state=5
            and project.id_user = :id_user
	        AND serviceset.close_date > LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))
            and	serviceset.close_date < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)
            group by MONTH(serviceset.close_date)'
        )
            ->bindValue(':id_user', $idUser)
            ->queryAll();

        return $query;
    }

    public function getSalesForPeriod($idUser, $from, $to)
    {
        /*$query = (new \yii\db\Query())
            ->select([
                'MONTH(serviceset.close_date) AS month',
                'SUM(service.cost) AS cost',
            ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->leftJoin('servicelist', 'servicelist.id_serviceset=serviceset.id_serviceset')
            ->leftJoin('service', 'service.id_service=servicelist.id_service')
            ->where([
                'serviceset.id_state' => 5,
                'project.id_user' => $idUser,
            ])
            ->andWhere(['>', 'serviceset.close_date', 'LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))'])
            ->andWhere(['<', 'serviceset.close_date', 'DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY)'])
            ->groupBy('MONTH(project.creation_date)')
            ->all();*/
        $query = \Yii::$app->db->createCommand(
            'select
	        MONTHNAME(serviceset.close_date) AS month,
            SUM(service.cost) AS cost
            from serviceset
            left Join project on project.id_project=serviceset.id_project
            left Join servicelist on servicelist.id_serviceset=serviceset.id_serviceset
            left Join service on service.id_service=servicelist.id_service
            where serviceset.id_state=5
            and project.id_user = :id_user
	        AND project.creation_date >= :first_date
	        and project.creation_date <= :last_date
            group by MONTH(serviceset.close_date)'
        )
            ->bindValue(':id_user', $idUser)
            ->bindValue(':first_date', $from)
            ->bindValue(':last_date', $to)
            ->queryAll();

        return $query;
    }



}
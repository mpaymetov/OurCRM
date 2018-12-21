<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 21.11.2018
 * Time: 10:05
 */

namespace app\db_modules;


class HeadStatisticDbQuery
{

    //запросы данных для руководителя

    public function getServicesetNumByStateAndDepartment($idDepartment)
    {
        $query = (new \yii\db\Query())
            ->select([
                'serviceset.id_state AS state',
                'COUNT(*) AS num'
            ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->leftJoin('user', 'user.id_user=project.id_user')
            ->where(['user.id_department' => $idDepartment])
            ->andWhere(['<', 'serviceset.id_state', '5'])
            ->groupBy('serviceset.id_state')
            ->all();

        return $query;
    }


    public function getProjectNumberByDepartmentForPeriod($idDepartment, $from, $to)
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
	        MONTH(project.creation_date) AS `month`,
	        YEAR(project.creation_date) AS `year`,
	        COUNT(*) AS `all`,
            SUM(serviceset.id_state=5) AS close,
            SUM(serviceset.id_state=6) AS cancellation
            from serviceset
            left join project on project.id_project=serviceset.id_project
            left join user on user.id_user=project.id_user
            where user.id_department = :id_department and 
	        project.creation_date >= :first_date and
	        project.creation_date <= :last_date
            group By MONTH(project.creation_date), YEAR(project.creation_date)')
            ->bindValue(':id_department', $idDepartment)
            ->bindValue(':first_date', $from)
            ->bindValue(':last_date', $to)
            ->queryAll();
        return $query;
    }


    public function getSalesByDepartmentForPeriod($idDepartment, $from, $to)
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
	        MONTH(serviceset.close_date) AS `month`,
	        YEAR(serviceset.close_date) AS `year`,
            SUM(service.cost) AS sale
            from serviceset
            left Join project on project.id_project=serviceset.id_project
            left Join servicelist on servicelist.id_serviceset=serviceset.id_serviceset
            left Join service on service.id_service=servicelist.id_service
            left join user on user.id_user=project.id_user
            where serviceset.id_state = 5
            and user.id_department = :id_department
	        AND project.creation_date >= :first_date
	        and project.creation_date <= :last_date
            group by MONTH(serviceset.close_date), YEAR(serviceset.close_date)'
        )
            ->bindValue(':id_department', $idDepartment)
            ->bindValue(':first_date', $from)
            ->bindValue(':last_date', $to)
            ->queryAll();

        return $query;
    }


}
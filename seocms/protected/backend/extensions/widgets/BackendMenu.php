<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 06.06.13
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

class BackendMenu extends CWidget{


    public function run()
    {
        $connection = Yii::app()->db;
        $role = !(isset(Yii::app()->user->role)) ? 'Guest' : Yii::app()->user->role == 'admin' ? 'overAllManager' : Yii::app()->user->role;
        $sql = 'select * from usermenu where role=:role AND level !=1 AND visible =1 order by root,lft';
        $command = $connection->createCommand($sql);
        $command->bindParam(':role',$role,PDO::PARAM_STR);
        $menu = $command->queryAll();

        $this->render('backendMenu',array(
            'menu'=>$menu,
        ));
    }
}
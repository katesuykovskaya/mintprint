<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 13.06.13
 * Time: 11:56
 * To change this template use File | Settings | File Templates.
 */

class ModuleUrlManager {
    static function collectRules()
    {
        if(!empty(Yii::app()->modules))
        {
            foreach(Yii::app()->modules as $moduleName=>$config)
            {
                $module = Yii::app()->getModule($moduleName);
                if(!empty($module->urlRules))
                {
                    Yii::app()->getUrlManager()->addRules($module->urlRules);
                }
            }
        }
        return true;
    }

}
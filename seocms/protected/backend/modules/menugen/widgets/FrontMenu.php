<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 25.06.13
 * Time: 14:33
 * To change this template use File | Settings | File Templates.
 */

class FrontMenu extends CWidget
{

//    public $css = 'mainmenu.css';
    public $css;
//    public $js = 'mainmenu.js';
    public $js;
    public $menuName;

    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
        Yii::import('application.backend.modules.menugen.models.Sitemenu');
        Yii::import('application.backend.modules.menugen.models.SitemenuTranslate');
    }

    protected function registerClientScript()
    {
        // …подключаем здесь файлы CSS или JavaScript…

        $cs=Yii::app()->clientScript;
        if($this->css!== null)
            $cs->registerCssFile('/css/'.$this->css);
        if($this->js !== null)
            $cs->registerScriptFile('/js/'.$this->js);
    }

    public function run()
    {
        $this->registerClientScript();

        $criteria = new CDbCriteria;
        $criteria->condition = "t.type=:type AND t.lft!='1'";
        $criteria->params = array(':type'=>$this->menuName);
        $criteria->order = 'lft';
        $menu = Sitemenu::model()->with(array('translation'=>array(
            'joinType'=>'LEFT JOIN',
            'on'=>'translation.t_lang=:lang',
            'condition'=>'t_hide=0',
            'params'=>array(':lang'=>Yii::app()->language),
        )))->findAll($criteria);
        $this->render('frontMenu',array(
            'menu'=>$menu,
        ));
    }
}
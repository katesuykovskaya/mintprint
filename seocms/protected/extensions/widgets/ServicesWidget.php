<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 25.11.13
 * Time: 15:56
 */

class ServicesWidget extends CWidget
{

    public $pages = array();

    public function init()
    {
        Yii::import('application.backend.modules.pages.models.StaticPages');
        Yii::import('application.backend.modules.pages.models.PagesTranslate');
    }

    public function run()
    {
        $in = implode(',',$this->pages);
        $allPages = Yii::app()->db->createCommand(
            "select * from static_pages
            left join translate_pages
            on static_pages.page_id=translate_pages.page_id
            where static_pages.page_id in (".$in.")")
            ->queryAll();
        $this->render('servicesWidget',array(
            'allPages'=>$allPages,
        ));
    }

} 
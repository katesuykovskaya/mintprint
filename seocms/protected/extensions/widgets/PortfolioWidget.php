<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 11.12.13
 * Time: 17:19
 */

class PortfolioWidget extends CWidget
{
    public $pages;

    public function init()
    {
        Yii::import('application.backend.modules.pages.models.StaticPages');
        Yii::import('application.backend.modules.pages.models.PagesTranslate');
    }

    public function run()
    {
        $in = implode(',',$this->pages);
        $allPages = Yii::app()->db->createCommand(
            "select static_pages.page_id,translate_pages.t_title from static_pages
            left join translate_pages
            on static_pages.page_id=translate_pages.page_id
            where static_pages.page_id in (".$in.")")
            ->queryAll();

        $contentArray = array();
        foreach($allPages as $key=>$value){
            $model = StaticPages::model()->findByPk($value['page_id']);
            $contentArray[$value['page_id']] = $model->children()->findAll();
        }

        $this->render('portfolioWidget',array(
            'allPages'=>$allPages,
            'content'=>$contentArray
        ));
    }
}
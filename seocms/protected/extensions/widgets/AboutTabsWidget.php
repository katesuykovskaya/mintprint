<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 11.12.13
 * Time: 17:19
 */

class AboutTabsWidget extends CWidget
{
    public $parent;

    public function init()
    {
        Yii::import('application.backend.modules.pages.models.StaticPages');
        Yii::import('application.backend.modules.pages.models.PagesTranslate');
        Yii::import('application.backend.modules.attach.models.Attachment');
    }

    public function run()
    {
        $parent = StaticPages::model()->findByPk($this->parent);
        $children = $parent->children()->findAll();
        $client_logos = Attachment::model()->findAllByAttributes(array('attachment_entity'=>'StaticPages','entity_id'=>31),array('order'=>'position'));
        $this->render('aboutTabsWidget',array(
            'children'=>$children,
            'logos'=>$client_logos
        ));
    }
}
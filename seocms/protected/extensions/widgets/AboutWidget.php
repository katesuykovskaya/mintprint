<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 11.12.13
 * Time: 15:28
 */

class AboutWidget extends CWidget
{

    public function init()
    {
        Yii::import('application.backend.modules.pages.models.StaticPages');
        Yii::import('application.backend.modules.pages.models.PagesTranslate');
    }

    public function run()
    {
        $this->render('aboutWidget');
    }
} 
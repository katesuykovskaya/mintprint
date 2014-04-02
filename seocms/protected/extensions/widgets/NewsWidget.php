<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kate
 * Date: 27.01.14
 * Time: 17:01
 * To change this template use File | Settings | File Templates.
 */
class NewsWidget extends CWidget {
    public $news;
    public function init() {

    }

    public function run() {
        $this->render('newsWidget', array(
//            'newsAll'=>$this->news['all'],
//            'newsClub'=>$this->news['club'],
            'news'=>$this->news
        ));
    }
}
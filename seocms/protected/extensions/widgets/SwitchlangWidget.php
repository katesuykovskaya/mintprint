<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kate
 * Date: 30.01.14
 * Time: 12:51
 * To change this template use File | Settings | File Templates.
 */

class SwitchlangWidget extends CWidget {
    public $model;
    public $translit;
    public $id;
    public $id_name;
    public $index;
    public $prefix;
    public $sufix;
    public $from;
    public $url;
    public $search_attr;

    public function run() {
        Yii::import('application.backend.components.MultilangUrl');
        if($this->from == 'model') {
            $urls = MultilangUrl::createFromModel(array(
                'model' => $this->model,
                'translit' => $this->translit,
                'search_attr'=>$this->search_attr,
                'index' => $this->index,
                'prefix' => $this->prefix,
                'sufix' => $this->sufix
            ));
        } elseif($this->from == 'page') {
            $urls = MultilangUrl::createFromPage($this->url);
        } elseif($this->from == 'prev') {
            $urls = MultilangUrl::createFromPrevious();
        } else
            $urls = MultilangUrl::createFromUrl();
        $this->render('switchlangWidget', array('urls' => $urls));
    }
}
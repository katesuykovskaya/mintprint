<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 22.05.13
 * Time: 17:04
 * To change this template use File | Settings | File Templates.
 */

class Multilanguage extends CActiveRecordBehavior{

    public $languages = array();
    public $relationName = 'translation';
    public $translateAttributes = array();
    private $iteration = 0;

    /**
     * @param $model
     * @param bool $param  - if true - create new Model instance, else - load model from DB
     * @return array - array with data to store in Yii booster's each tab content
     */
    public function tabsArray($model,$param = true)
    {
        $tabsArray = [];
        foreach(Yii::app()->params['languages'] as $language){
            if($param) {
                if(Yii::app()->language == $language['langcode']) {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $model,
                                $language['langcode']
                            ),
                        'active'=>true
                    );
                } else {
                    $tabsArray[] = [
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $model,
                                $language['langcode']
                            )
                    ];
                }
            } else {
                if(Yii::app()->language == $language['langcode']) {
                    $tabsArray[] = [
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $this->loadMultilangModel($model->id,$language['langcode']),
                                $language['langcode'],$param=false
                            ),
                        'active'=>true
                    ];
                } else {
                    $tabsArray[] = [
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $this->loadMultilangModel($model->id,$language['langcode']),
                                $language['langcode'],
                                $param=false)
                    ];
                }
            }
        }
        return $tabsArray;
    }

    public function getTabContent($model,$lang,$param = true)
    {
//        $fieldsArray = $model->translateAttributes;
        $fieldsArray = $this->owner->translateAttributes;
        $content = '';

        if($param) {
            foreach($fieldsArray as $key=>$field) {

                if($field['label'] !== 't_meta')
                    $label = CHtml::activeLabel($model, $field['label']);
                else
                    $label = '<h5 class="page-header">'.$field['label'].':</h5>';

                if($field['fieldType'] !== 'dropDownList'){
                    $formField = 'active'.ucfirst($field['fieldType']);
                    $textField = CHtml::$formField($model, $field['label'].'['.$lang.']',$field['htmlOptions']);
                } else {
                    if($field['label'] !== 't_meta'){
                        $formField = 'active'.ucfirst($field['fieldType']);
                        $textField = CHtml::dropDownList('GalleryTranslate['.$field["label"].']['.$lang.']','',$field['value'],$field['htmlOptions']).'<hr />';
                    } else {
                        $textField = '';
                        foreach($field['value'] as $key=>$value)
                            $textField .= CHtml::label($value,'GalleryTranslate_t_meta_'.$value.'_'.$lang).'<br />'.CHtml::textField('GalleryTranslate[t_meta]['.$value.']['.$lang.']', '',$field['htmlOptions']);
                    }
                }

                $content .= $label.$textField;
            }
        } else {
            foreach($fieldsArray as $key=>$field) {
                /* $model->translation can be NULL if the new project language was added and no
                 * page translation instance was created, it will be created after page save automatically,
                 * but not during adding new language support
                 * */
                if($model->translation === null)
                    $model->translation = new GalleryTranslate;

                if($field['label'] !== 't_meta')
                    $label = CHtml::activeLabel($model, $field['label']);
                else
                    $label = '<h5 class="page-header">'.$field['label'].':</h5>';

                $formField = 'active'.ucfirst($field['fieldType']);
                $htmlOptions = $field['htmlOptions'];
                $htmlOptions['name'] = 'GalleryTranslate['.$field['label'].']['.$lang.']';

                if($field['fieldType'] !== 'dropDownList') {
                    $textField = CHtml::$formField($model->translation[$lang], $field['label'],$htmlOptions).'<hr />';
                } else {
                    if($field['label'] !== 't_meta'){
                        $textField = CHtml::dropDownList('GalleryTranslate['.$field["label"].']['.$lang.']',$model->translation[$lang][$field['label']],$field['value'],$htmlOptions).'<hr />';
                    } else {
                        $meta = unserialize($model->translation[$lang]['t_meta']);
                        $textField = '';
                        foreach($field['value'] as $key=>$value){
                            $textField .= CHtml::label($value,'GalleryTranslate_t_meta_'.$value.'_'.$lang).'<br />'.
                                CHtml::textField('GalleryTranslate[t_meta]['.$value.']['.$lang.']',$meta[$value][$lang],$field['htmlOptions']);
                        }
                    }
                }
                $content .= $label.$textField;
            }
        }

        return $content;
    }

    public function loadMultilangModel($id,$lang)
    {
        $model = $this->owner
            ->with(array(
                'translation'=>array(
                    'joinType'=>'LEFT JOIN',
                    'on'=>'translation.t_language=:lang',
                    'params'=>array(':lang'=>$lang),
                )))->findByAttributes(array('id'=>$id));
        return $model;
    }
}
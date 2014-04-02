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
    public $iteration = 0;

//    public function loadRelatedTranslation($id)
//    {
//        $connection = Yii::app()->db;
//        $sql = 'select t1.id as source_id, t2.id, t2.t_lang, t2.t_text from site_menu as t1 inner join sitemenu_translate as t2 on t1.id=t2.source_id where source_id=:id';
//        $query = $connection->createCommand($sql);
//        $query->bindParam(':id',$id,PDO::PARAM_INT);
//        $result = $query->queryAll();
//
//        $newArr = array();
//        foreach($result as $key=>$value)
//        {
//            $newArr[$value['t_lang']] = $value;
//        }
//        unset($result);
//
//        $output = array();
//        foreach($this->languages as $key=>$arr)
//        {
//                $output[$key] = array(
//                    'label'=>$arr['lang'],
//                    'content'=>CHtml::textField("t_text[$key]",isset($newArr[$key]['t_text']) ? $newArr[$key]['t_text'] : null),
//                    'active'=>($key == Yii::app()->language) ? true : false,
//                );
//        }
//
//        return $output;
//    }

    /**
     * @param null $languages (array of project languages if !set Yii::app()->params['languages'] will be used)
     * @param null $translateAttributes (array of attributes(fields) that would be translated)
     * @param null $validators (array of validators,needed for scenarios, if translatable field is not in array - do not show it in form scenario)
     * @param null $model (is set then we want to update some model)
     * @return array (returns array divided to arrays by languages with content: 'label','content','active' - which used in tabs widget)
     */

//    public function getTranslateData($languages = null,$translateAttributes = null,$validators = null, $model=null)
//    {
//        $outputArray = array();
//        $contentArr = array();
//        $languages = !$languages ? : Yii::app()->params['languages'];
//
//        foreach($languages as $language=>$langParams)
//        {
//            $outputArray[$language]['label'] = $langParams['lang'];
//            $outputArray[$language]['active'] = $language == Yii::app()->language ? true : false;
//        }
//
//        foreach(Yii::app()->params['languages'] as $language=>$langParams)
//        {
//            if(!$model){
//                $contentArr[$langParams['langcode']]['content'] = $this->getFields($translateAttributes,$langParams['langcode'],$validators);
//            }
//            else {
//                $contentArr[$langParams['langcode']]['content'] = $this->getFields($translateAttributes,$langParams['langcode'],$validators, $model);
//                $this->iteration++;
//            }
//        }
//
//        return array_merge_recursive($outputArray,$contentArr);
//    }

    /**
     * @param $array (array of attributes(fields) that would be translated)
     * @param $language (language which this field will be assigned to)
     * @param $validators (array of validators,needed for scenarios, if translatable field is not in array - do not show it in form scenario)
     * @param null $model (is set then we want to update some model)
     * @return string (concatenated html which will be inserted into the widget that outputs create/update form)
     */
//    private function getFields($array,$language, $validators=null, $model=null)
//    {
//        if(!$validators)
//            $validators = array();
//
//        $content = '';
//        if(!$model->isNewRecord){
//            foreach($array as $key=>$value)
//            {
//                if(in_array($value['label'],$validators))
//                {
//                $label = CHtml::label($value['label'],$value['label'].'['.$language.']');
//
//                    if($value['fieldType']=='checkBox'){
//                        $val = isset($model->translation[$language][$value['label']]) ? $model->translation[$language][$value['label']] : '';
//                        $field = CHtml::checkBox($value['label'].'['.$language.']',$val == 1 ? true : false, array('value'=>$value['value'])
//                                ,isset($value['htmlOptions']) ? $value['htmlOptions'] : []).'<br />';
//                    } elseif ($value['fieldType']==='dropDownList'){
////                        $val = isset($model->translation[$language][$value['label']]) ? $model->translation[$language][$value['label']] : '';
////                        $field = CHtml::dropDownList($value['label'].'['.$language.']','select',
////                                $value['value']
//////                                ,['id'=>$value['label'].'_'.$language]
////                                ,isset($value['htmlOptions']) ? $value['htmlOptions'] : []
////                            ).'<br />';
//                            $field = '<select id="test">';
//                            foreach($value['value'] as $key=>$val){
//                                $field .= '<option value="'.$key.'">'.$val.'</option>';
//                            }
//                            $field .= '</select>';
//                    } else {
//                        $val = isset($model->translation[$language][$value['label']]) ? $model->translation[$language][$value['label']] : '';
//                        $field = CHtml::$value['fieldType']($value['label'].'['.$language.']',$val,array('id'=>$value['label'].'_'.$language)
//                                ,isset($value['htmlOptions']) ? $value['htmlOptions'] : []).'<br />';
//                    }
//
//                $content .= $label.$field;
//
//                }
//            }
//        } else {
//                foreach($array as $key=>$value)
//                {
//                    if(in_array($value['label'],$validators))
//                    {
//                    $label = CHtml::label($value['label'],$value['label'].'['.$language.']');
//
//                        if($value['fieldType']=='checkBox'){
//                            $field = CHtml::checkBox($value['label'].'['.$language.']',$value['label'] == 1 ? true : false,array('value'=>$value['label'])
//                                    ,isset($value['htmlOptions']) ? $value['htmlOptions'] : array()).'<br />';
//                        } elseif ($value['fieldType']=='dropDownList'){
////                        $val = isset($model->translation[$language][$value['label']]) ? $model->translation[$language][$value['label']] : '';
////                            $field = CHtml::dropDownList($value['label'].'['.$language.']','',
////                                    ['1'=>'1','2'=>'2','5'=>'5']
//////                                ,['id'=>$value['label'].'_'.$language]
////                                    ,isset($value['htmlOptions']) ? $value['htmlOptions'] : []
////                                ).'<br />';
//                            $field = '<select id="test">';
//                            foreach($value['value'] as $key=>$val){
//                                $field .= '<option value="'.$key.'">'.$val.'</option>';
//                            }
//                            $field .= '</select>';
//                        } else {
//                            $field = CHtml::$value['fieldType']($value['label'].'['.$language.']',''
//                                    ,isset($value['htmlOptions']) ? $value['htmlOptions'] : array()).'<br />';
//                        }
//                    $content .= $label.$field;
//                    }
//                }
//            }
//        return $content;
//    }
}
<?php

/**
 * This is the model class for table "site_menu".
 *
 * The followings are the available columns in table 'site_menu':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $text
 * @property string $url
 */
class Sitemenu extends CActiveRecord
{
    public $parent;
    public $link;
    public $page;
    private $_menucss = 'mainmenu.css';
    public static $menujs = 'mainmenu.js';

    const ADMIN_TREE_CONTAINER_ID='site_menu_admin_tree';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sitemenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('root, lft, rgt, level, text, url', 'required'),
//			array('root, lft, rgt, level', 'numerical', 'integerOnly'=>true),
//			array('text, url', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('parent, link_type, type','required','on'=>'Category'),
            array('t_text, t_hide','safe','on'=>'Category'),
            array('parent, link_type, type','required','on'=>'Page'),
            array('t_text, t_hide, t_url','safe','on'=>'Page'),
            array('parent, link_type, type','required','on'=>'Url'),
            array('t_text, t_hide, t_url','safe','on'=>'Url'),
			array('id, root, lft, rgt, level, link_type, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'translation'=>array(self::HAS_MANY,'SitemenuTranslate','source_id','index'=>'t_lang'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'root' => 'Root',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'url' => 'Url',
            'type'=>'Menu Type'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('root',$this->root);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
    {
        return array(
            'NestedSetBehavior'=>array(
                'class'=>'application.backend.components.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
                'hasManyRoots'=>true,
            ),
            'Multilanguage'=>array(
                'class'=>'application.backend.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                                't_text'=>array(
                                    'label'=>'t_text',
                                    'fieldType'=>'textField',
                                    'value'=>'',
                                    'htmlOptions'=>array(
                                    ),
                                ),
                                't_hide'=>array(
                                    'label'=>'t_hide',
                                    'fieldType'=>'checkBox',
                                    'value'=>'',
                                    'htmlOptions'=>array(
                                    ),
                                ),
                                't_url'=>array(
                                    'label'=>'t_url',
                                    'fieldType'=>'textField',
                                    'value'=>'',
                                    'htmlOptions'=>array(
                                    ),
                                ),
                ),
            ),
        );
    }

    public function loadRelatedTranslation($id)
    {
        $connection = Yii::app()->db;
        $sql = 'select t1.id as source_id, t2.id, t2.t_lang, t2.t_text from site_menu as t1 inner join sitemenu_translate as t2 on t1.id=t2.source_id where source_id=:id';
        $query = $connection->createCommand($sql);
        $query->bindParam(':id',$id,PDO::PARAM_INT);
        $result = $query->queryAll();

        $newArr = array();
        foreach($result as $key=>$value)
        {
            $newArr[$value['t_lang']] = $value;
        }
        unset($result);

        $output = array();
        foreach($this->languages as $key=>$arr)
        {
            $output[$key] = array(
                'label'=>$arr['lang'],
                'content'=>CHtml::textField("t_text[$key]",isset($newArr[$key]['t_text']) ? $newArr[$key]['t_text'] : null),
                'active'=>($key == Yii::app()->language) ? true : false,
            );
        }

        return $output;
    }

    public function getTranslateData($languages = null,$translateAttributes = null,$validators = null, $model=null)
    {
        $outputArray = array();
        $contentArr = array();
        $languages = !$languages ? : Yii::app()->params['languages'];

        foreach($languages as $language=>$langParams)
        {
            $outputArray[$language]['label'] = $langParams['lang'];
            $outputArray[$language]['active'] = $language == Yii::app()->language ? true : false;
        }

        foreach(Yii::app()->params['languages'] as $language=>$langParams)
        {
            if(!$model){
                $contentArr[$langParams['langcode']]['content'] = $this->getFields($translateAttributes,$langParams['langcode'],$validators);
            }
            else {
                $contentArr[$langParams['langcode']]['content'] = $this->getFields($translateAttributes,$langParams['langcode'],$validators, $model);
                $this->iteration++;
            }
        }

        return array_merge_recursive($outputArray,$contentArr);
    }

    private function getFields($array,$language, $validators=null, $model=null)
    {
        if(!$validators)
            $validators = array();

        $content = '';
        if(!$model->isNewRecord){
            foreach($array as $key=>$value)
            {
                if(in_array($value['label'],$validators))
                {
                    $label = CHtml::label(Yii::t('backend',$value['label']),$value['label'].'['.$language.']');

                    if($value['fieldType']=='checkBox'){
                        $val = isset($model->translation[$language][$value['label']]) ? $model->translation[$language][$value['label']] : '';
                        $field = CHtml::checkBox($value['label'].'['.$language.']',$val == 1 ? true : false, array('value'=>$value['value'])
                            ,isset($value['htmlOptions']) ? $value['htmlOptions'] : []).'<br />';
                    } elseif ($value['fieldType']==='dropDownList'){
                        $field = '<select id="test">';
                        foreach($value['value'] as $key=>$val){
                            $field .= '<option value="'.$key.'">'.$val.'</option>';
                        }
                        $field .= '</select>';
                    } else {
                        $val = isset($model->translation[$language][$value['label']]) ? $model->translation[$language][$value['label']] : '';
                        $field = CHtml::$value['fieldType']($value['label'].'['.$language.']',$val,array('id'=>$value['label'].'_'.$language)
                            ,isset($value['htmlOptions']) ? $value['htmlOptions'] : []).'<br />';
                    }

                    $content .= $label.$field;

                }
            }
        } else {
            foreach($array as $key=>$value)
            {
                if(in_array($value['label'],$validators))
                {
                    $label = CHtml::label(Yii::t('backend',$value['label']),$value['label'].'['.$language.']');

                    if($value['fieldType']=='checkBox'){
                        $field = CHtml::checkBox($value['label'].'['.$language.']',$value['label'] == 1 ? true : false,array('value'=>$value['label'])
                            ,isset($value['htmlOptions']) ? $value['htmlOptions'] : array()).'<br />';
                    } elseif ($value['fieldType']=='dropDownList'){
                        $field = '<select id="test">';
                        foreach($value['value'] as $key=>$val){
                            $field .= '<option value="'.$key.'">'.$val.'</option>';
                        }
                        $field .= '</select>';
                    } else {
                        $field = CHtml::$value['fieldType']($value['label'].'['.$language.']',''
                            ,isset($value['htmlOptions']) ? $value['htmlOptions'] : array()).'<br />';
                    }
                    $content .= $label.$field;
                }
            }
        }
        return $content;
    }

    public static  function printULTree(){

        $connection = Yii::app()->db;
        $sql = "select * from site_menu
                    left join sitemenu_translate
                    on site_menu.id=sitemenu_translate.source_id
                    where type='mainmenu' AND t_lang='".Yii::app()->language."' AND t_hide='0'
                    order by root,lft";
        $command = $connection->createCommand($sql);
        $categories = $command->queryAll();
        $level=0;

        if(!empty($categories))
        {
            foreach($categories as $n=>$category)
            {
                if($category['level']==$level)
                    echo CHtml::closeTag('li')."\n";
                else if($category['level']>$level)
                    echo CHtml::openTag('ul')."\n";
                else
                {
                    echo CHtml::closeTag('li')."\n";

                    for($i=$level-$category['level'];$i;$i--)
                    {
                        echo CHtml::closeTag('ul')."\n";
                        echo CHtml::closeTag('li')."\n";
                    }
                }
                echo CHtml::openTag('li',array('id'=>'node_'.$category['id'],'rel'=>$category['t_text']));
                echo CHtml::openTag('a',array('href'=>$category['t_url']));
                echo CHtml::encode(Yii::t('backend',$category['t_text']));
                echo CHtml::closeTag('a');

                $level=$category['level'];
            }

            for($i=$level;$i;$i--)
            {
                echo CHtml::closeTag('li')."\n";
                echo CHtml::closeTag('ul')."\n";
            }
        } else {
            echo CHtml::link(Yii::t('backend','Создать меню'),
                Yii::app()->urlManager->createUrl('/backend/menugen/sitemenu/createmenu',array('language'=>Yii::app()->language)),
                array('class'=>'btn'));
        }
    }

    public static function getTreeListData($type)
    {
        $arrCondition = new CDbCriteria;
        $arrCondition->condition = 'type=:type';
        $arrCondition->params = array(':type'=>$type);
        $arrCondition->order = 'lft';

        $arr = Sitemenu::model()->with(array('translation'=>array(
                'joinType'=>'LEFT JOIN',
                'on'=>'translation.t_lang=:lang',
                'params'=>array(':lang'=>Yii::app()->language),
            )))->findAll($arrCondition);

        $list = array();

        foreach($arr as $item){
            foreach(Yii::app()->params['languages'] as $key=>$language){
                $list[$item->id] = str_repeat(' - ',$item->level).' '.$item->translation[Yii::app()->language]->t_text;
            }
        }

        return $list;
    }

    public function afterSave()
    {
        parent::afterSave();

        if($this->isNewRecord)
        {
            foreach(Yii::app()->params['languages'] as $key=>$language)
            {
                $model = new SitemenuTranslate;
                $model->source_id = $this->id;
                $model->t_lang = $key;

                foreach($this->translateAttributes as $name=>$value)
                {
                    if($value['fieldType']=='checkBox')
                        $model->$value['label'] = isset($_POST[$value['label']][$key]) ? 1 : 0;
                    else
                        $model->$value['label'] = isset($_POST[$value['label']][$key]) ? $_POST[$value['label']][$key] : null;
                }
                $model->save(false);
            }
        } else {
            foreach(Yii::app()->params['languages'] as $key=>$language)
            {
                $model = SitemenuTranslate::model()->findByAttributes(array('source_id'=>$this->id,'t_lang'=>$key));
                if(!$model){
                    $model = new SitemenuTranslate;
                    $model->source_id = $this->id;
                    $model->t_lang = $key;
                }


                foreach($this->translateAttributes as $name=>$value)
                {
                    if($value['fieldType']=='checkBox')
                        $model->$value['label'] = isset($_POST[$value['label']][$key]) ? 1 : 0;
                    else
                        $model->$value['label'] = isset($_POST[$value['label']][$key]) ? $_POST[$value['label']][$key] : null;
                }

                $model->save(false);
            }
        }
    }

    public static function drawGrid($menu = null)
    {

        if(empty($menu))
        {
            $criteria = new CDbCriteria;
            $criteria->condition = "type='mainmenu' AND lft!='1'";
            $criteria->order = 'lft';
            $menu = Sitemenu::model()->with(array('translation'=>array(
                'joinType'=>'LEFT JOIN',
                'on'=>'translation.t_lang=:lang',
                'params'=>array(':lang'=>Yii::app()->language),
            )))->findAll($criteria);
        }

        echo'
        <table class="table table-bordered table-striped">
            <thead>
                <th> + </th>
                <th>text</th>
                <th>id</th>
                <th>root</th>
                <th>lft</th>
                <th>rgt</th>
                <th>level</th>
                <th>url</th>
                <th>type</th>
                <th>link_type</th>
                <th>kill</th>
                <th>hide</th>
            </thead>

            <tbody>';

        foreach($menu as $item)
        {

            $parent = $item->parent()->find();
            $children = $item->children()->findAll();
            $childrenNum = count($children);
            if(is_array($children)){
                $childrenArray = array();
                foreach($children as $key=>$child){
                    $childrenArray[] = $child->id;
                }
                $childrenString = implode(',',$childrenArray);
            }
            $descendants = $item->descendants()->findAll();
            if(is_array($descendants)){
                $descendantsArray = array();

                foreach($descendants as $key=>$descendant){
                    $descendantsArray[] = $descendant->id;
                }

                $descendantsString = implode(',',$descendantsArray);
            }

           if(($item->level == 2))
           {

               if($childrenNum != 0){
                   echo '<tr data-rowid='.$item->id.' children="'.$childrenString.'" descendants="'.$descendantsString.'">';
                   echo ' <td class="main">
                                <i class="icon-folder-open"></i>
                        </td>';
               } else {
                   echo '<tr data-rowid='.$item->id.'>';
                   echo '<td class="main">
                         </td>';
               }

           } else {

                if($childrenNum !=0){
                echo '<tr data-rowid="'.$item->id.'" class="hidden" children="'.$childrenString.'" descendants="'.$descendantsString.'">
                <td class="main"><i class="icon-folder-open"></i></td>';
               } else {
                   echo '<tr data-rowid='.$item->id.'
                    class="hidden">
                    <td class="main"></td>';
               }

            }

        echo '<td><span class="text">'.CHtml::link($item->translation[Yii::app()->language]->t_text,Yii::app()->urlManager->createUrl('/backend/menugen/sitemenu/updatemenu',
                array('id'=>$item->id,'language'=>Yii::app()->language)
            ));
        echo '</span></td>
        <td>'.$item->id.'</td>
        <td>'.$item->root.'</td>
        <td>'.$item->lft.'</td>
        <td>'.$item->rgt.'</td>
        <td>'.$item->level.'</td>
        <td>'.$item->translation[Yii::app()->language]['t_url'].'</td>
        <td>'.$item->type.'</td>
        <td>'.$item->link_type.'</td>';
        ?>
        <td><i class="icon-trash" data-toggle="tooltip" title="<?=Yii::t('backend','Удалить');?>" data-id="<?=$item->id?>"></i></td>
        <?php
            echo '<td>'.CHtml::link(
            ($item->translation[Yii::app()->language]->t_hide == 0 ) ?
            '<i class="icon-ok" data-state="'.$item->translation[Yii::app()->language]->t_hide.'" data-source_id="'.$item->translation[Yii::app()->language]->source_id.'"></i>' :
            '<i class="icon-remove" data-state="'.$item->translation[Yii::app()->language]->t_hide.'" data-source_id="'.$item->translation[Yii::app()->language]->source_id.'"></i>'
                            ,'#');

            echo '</td></tr>';
        }

        echo '</tbody></table>';
    }

    public static function drawAjaxGrid($language,$menu = null)
    {

        if(empty($menu)){
            $criteria = new CDbCriteria;
            $criteria->condition = "type='mainmenu' AND level='2'";
            $criteria->order = 'lft';
            $menu = Sitemenu::model()->with(array('translation'=>array(
                'joinType'=>'LEFT JOIN',
                'on'=>'translation.t_lang=:lang',
                'params'=>array(':lang'=>$language),
            )))->findAll($criteria);
        }

        echo'
            <table class="table table-bordered table-striped">
                <thead>
                    <th> + </th>
                    <th>text</th>
                    <th>id</th>
                    <th>url</th>
                    <th>link_type</th>
                    <th>kill</th>
                    <th>hide</th>
                </thead>

                <tbody>';

        foreach($menu as $item)
        {

            $parent = $item->parent()->find();
            $children = $item->children()->findAll();
            $childrenNum = count($children);
            if(is_array($children)){
                $childrenArray = array();
                foreach($children as $key=>$child){
                    $childrenArray[] = $child->id;
                }
                $childrenString = implode(',',$childrenArray);
            }
            $descendants = $item->descendants()->findAll();
            if(is_array($descendants)){
                $descendantsArray = array();

                foreach($descendants as $key=>$descendant){
                    $descendantsArray[] = $descendant->id;
                }

                $descendantsString = implode(',',$descendantsArray);
            }

            if(($item->level == 2))
            {

                if($childrenNum != 0){
                    echo '<tr id=row-'.$item->id.' parent='.$parent->id.' data-rowid='.$item->id.' children="'.$childrenString.'" descendants="'.$descendantsString.'" style="padding-left:0;">';
                    echo ' <td class="mainAjax">
                                    <i class="icon-folder-open"></i>
                            </td>';
                } else {
                    echo '<tr id=row-'.$item->id.' parent='.$parent->id.' data-rowid='.$item->id.' style="padding-left:0;">';
                    echo '<td class="mainAjax">
                             </td>';
                }

            } else {

                if($childrenNum !=0){
                    echo '<tr id=row-'.$item->id.' parent='.$parent->id.' data-rowid="'.$item->id.'" class="hidden" children="'.$childrenString.'" descendants="'.$descendantsString.'" style="padding-left:0;">
                    <td class="mainAjax"><i class="icon-folder-open"></i></td>';
                } else {
                    echo '<tr id=row-'.$item->id.' parent='.$parent->id.' data-rowid='.$item->id.'
                        class="hidden"  style="padding-left:0;">
                        <td class="mainAjax"></td>';
                }

            }

            echo '<td><span class="text">'.CHtml::link($item->translation[Yii::app()->language]->t_text,Yii::app()->urlManager->createUrl('/backend/menugen/sitemenu/updatemenu',
                    array('id'=>$item->id,'language'=>Yii::app()->language)
                ));
            echo '</span></td>
            <td>'.$item->id.'</td>
            <td>'.$item->translation[Yii::app()->language]['t_url'].'</td>
            <td>'.$item->link_type.'</td>';
            ?>
            <td><i class="icon-trash" data-toggle="tooltip" title="<?=Yii::t('backend','Удалить');?>" data-id="<?=$item->id?>"></i></td>
            <?php
            echo '<td>'.CHtml::link(
                    ($item->translation[Yii::app()->language]->t_hide == 1 || $item->translation[Yii::app()->language]->t_hide == 2) ?
                        '<i class="icon-remove" data-state="'.$item->translation[Yii::app()->language]->t_hide.'" data-source_id="'.$item->translation[Yii::app()->language]->source_id.'"></i>' :
                        '<i class="icon-ok" data-state="'.$item->translation[Yii::app()->language]->t_hide.'" data-source_id="'.$item->translation[Yii::app()->language]->source_id.'"></i>'

                    ,'#');

            echo '</td></tr>';
        }
    }

    public static function drawAjaxGrid2($language,$menu = null)
    {
        $openNodes = Yii::app()->session['openNodes'];

        if(!empty($menu))
        {
            $criteria = new CDbCriteria;
            $criteria->condition = "type=:menu AND lft!='1'";
            $criteria->params = array(':menu'=>$menu);
            if(is_array($openNodes)){
                $criteria->addInCondition('t.id',$openNodes);
            } else {
                $criteria->addCondition('level=2');
            }

            $criteria->order = 'lft';
            $menu = Sitemenu::model()->with(array('translation'=>array(
                'joinType'=>'LEFT JOIN',
                'on'=>'translation.t_lang=:lang',
                'params'=>array(':lang'=>$language),
            )))->findAll($criteria);
        } else {
            throw new CHttpException('404', Yii::t('backend','По Вашему запросу ничего не найдено!'));
        }

        echo'<table class="table table-bordered table-striped">
                <thead>
                    <th> + </th>
                    <th>'.Yii::t('backend','Текст').'</th>
                    <th>'.Yii::t('backend','id').'</th>
                    <th>'.Yii::t('backend','Ссылка').'</th>
                    <th>'.Yii::t('backend','Тип').'</th>
                    <th>'.Yii::t('backend','Удалить').'</th>
                    <th>'.Yii::t('backend','Скрыть').'</th>
                </thead>

                <tbody>';
        foreach($menu as $item)
        {

            $parent = $item->parent()->find();
            $children = $item->children()->findAll();
            $childrenNum = count($children);
            if(is_array($children)){
                $childrenArray = array();
                foreach($children as $key=>$child){
                    $childrenArray[] = $child->id;
                }
                $childrenString = implode(',',$childrenArray);
            }
            $descendants = $item->descendants()->findAll();
            if(is_array($descendants)){
                $descendantsArray = array();

                foreach($descendants as $key=>$descendant){
                    $descendantsArray[] = $descendant->id;
                }

                $descendantsString = implode(',',$descendantsArray);
            }
            $padding = ($item->level-2)*20 <= 100 ? ($item->level-2)*20 : 100;

                if($childrenNum != 0){
                    echo '<tr id=row-'.$item->id.' parent='.$parent->id.' data-rowid='.$item->id.' children="'.$childrenString.'" descendants="'.$descendantsString.'" style="padding-left:0;">';
                    echo '<td class="mainAjax"></td>
                          <td><span class="text" style="padding-left: '.$padding.'px;">'.CHtml::link($item->translation[Yii::app()->language]->t_text,Yii::app()->urlManager->createUrl('/backend/menugen/sitemenu/updatemenu',
                            array('id'=>$item->id,'language'=>Yii::app()->language)
                        ));
                    echo '</span></td>';
                } else {
                    echo '<tr id=row-'.$item->id.' parent='.$parent->id.' data-rowid='.$item->id.' style="padding-left:0;">';
                    echo '<td class="mainAjax"></td>
                          <td><span class="text" style="padding-left: '.$padding.'px;">'.CHtml::link($item->translation[Yii::app()->language]->t_text,Yii::app()->urlManager->createUrl('/backend/menugen/sitemenu/updatemenu',
                            array('id'=>$item->id,'language'=>Yii::app()->language)
                            ));
                    echo '</span></td>';
                }

            echo '<td>'.$item->id.'</td>
            <td>'.$item->translation[Yii::app()->language]['t_url'].'</td>
            <td>'.$item->link_type.'</td>';
            ?>
                <td><i class="icon-trash" data-toggle="tooltip" title="<?=Yii::t('backend','Удалить');?>" data-id="<?=$item->id?>"></i></td>
            <?php
            echo '<td>'.CHtml::link(
                    ($item->translation[Yii::app()->language]->t_hide == 1 || $item->translation[Yii::app()->language]->t_hide == 2) ?
                        '<i class="icon-remove" data-state="'.$item->translation[Yii::app()->language]->t_hide.'" data-source_id="'.$item->translation[Yii::app()->language]->source_id.'"></i>' :
                        '<i class="icon-ok" data-state="'.$item->translation[Yii::app()->language]->t_hide.'" data-source_id="'.$item->translation[Yii::app()->language]->source_id.'"></i>'
                    ,'#');
            echo '</td></tr>';
        }
        echo '</tbody></table>';
    }


    public function getCss()
    {
        return $this->_menucss;
    }

    public function setCss($css)
    {
        return $this->_menucss = $css;
    }
}
?>

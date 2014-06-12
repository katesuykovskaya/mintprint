<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property integer $page_id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $img
 * @property string $t_title
 * @property string $t_lang
 * @property string $t_mtitle
 * @var $this->translation PagesTranslate
 *
 */
class StaticPages extends CActiveRecord
{
    const PAGES_TREE_CONTAINER_ID='static_pages_tree';
    
    public $t_title;
    public $t_lang;
    public $t_mtitle;

    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StaticPages the static model class
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
		return 'static_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('translit', 'length', 'max'=>255),
			// The following rule is used by search().
            array('img', 'file', 'types'=>'jpg, jpeg, gif, png','allowEmpty'=>true),
			// Please remove those attributes that should not be searched.
			array('page_id, t_title, t_lang, t_mtitle', 'safe', 'on'=>'search'),
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
            'translation'=>array(self::HAS_MANY,'PagesTranslate','page_id', 'index'=>'t_lang'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => 'ID',
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
        $criteria->with = array(
                            'translation'=>array(
                                'joinType'=>'LEFT JOIN',
                                'on'=>'translation.t_lang=:lang',
                                'params'=>array(':lang'=>Yii::app()->language)
                            )
        );

		$criteria->compare('page_id',$this->page_id);
        $criteria->compare('translation.t_title', $this->t_title);
        $criteria->compare('translation.t_mtitle', $this->t_mtitle);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        

    /**
     * @param $model - PagesTranslate model
     * @param null $postTitle - posted title which will be translitered
     * @param $language - current language which the data is of
     */
    private function updateMenuUrl($model,$postTitle=null,$language)
    {
        Yii::import('application.backend.modules.menugen.models.*');
        if($postTitle){
            $menumodel = SitemenuTranslate::model()->findByAttributes(array('t_url'=>$model->t_translit,'t_lang'=>$language));
                if(isset($menumodel)){
                    $translit = Translit::cyrillicToLatin($postTitle[$language]);
                    $menumodel->t_url = $translit;
                    $menumodel->save(false);
                }
        }
    }

    public function behaviors()
    {
        return array(
            'nestedSetBehavior'=>array(
                'class'=>'ext.behaviors.trees.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
            ),
            'AttachmentBehavior'=>array(
                'class'=>'application.backend.modules.attach.components.AttachmentBehavior',
                'entity_id'=>$this->page_id,
                'upload_path'=>Yii::getPathOfAlias('webroot').'/uploads/',
            ),
            'Multilanguage'=>array(
                'class'=>'application.backend.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                    't_title'=>array(
                        'label'=>'t_title',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_desc'=>array(
                        'label'=>'t_desc',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_h1'=>array(
                        'label'=>'t_h1',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_content'=>array(
                        'label'=>'t_content',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'tinyEditor'
                        ),
                    ),
                    't_translit'=>array(
                        'label'=>'t_translit',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_mtitle'=>array(
                        'label'=>'t_mtitle',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_mdesc'=>array(
                        'label'=>'t_mdesc',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge',
                            'rows'=>6
                        ),
                    ),
                    't_mkeywords'=>array(
                        'label'=>'t_mkeywords',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge',
                            'rows'=>6
                        ),
                    ),
                ),
            ),
        );
    }

    public function afterSave() {
        if($this->isNewRecord) {
            $languages = Yii::app()->params['languages'];

            foreach($languages as $language) {
                $lang = new PagesTranslate;
                $lang->page_id = $this->page_id;
                $lang->t_lang = $language['langcode'];
//                die(CVarDumper::dump($this->translateAttributes, 7, true));
                foreach($this->translateAttributes as $field) {
                    if($field['label']==='t_translit') {
                        $phrase = !empty($_POST['PagesTranslate']['t_translit'][$language['langcode']])
                            ? $_POST['PagesTranslate']['t_translit'][$language['langcode']] :
                            isset($_POST['PagesTranslate']['t_title'][$language['langcode']]) ?
                                Translit::cyrillicToLatin ($_POST['PagesTranslate']['t_title'][$language['langcode']])
                            : null;
//                        die($phrase);
                        $translit = PagesTranslate::model()->findByAttributes(array('t_translit'=>$phrase))
                            ? $phrase.'-'.$this->page_id
                            : $phrase;
                        $lang->t_translit = $translit;
                    } else {
                        $lang->$field['label'] = isset($_POST['PagesTranslate'][$field['label']][$language['langcode']])
                            ? $_POST['PagesTranslate'][$field['label']][$language['langcode']]
                            : null;
                    }
                }
            $lang->save(false);
            }
        } else {
            $languages = Yii::app()->params['languages'];

            foreach($languages as $language){
                $lang = PagesTranslate::model()->findByAttributes(
                    array(
                        'page_id'=>$this->page_id,
                        't_lang'=>$language['langcode']
                    )
                );
                if($lang === null){
                    $lang = new PagesTranslate;
                    $lang->page_id = $this->page_id;
                    $lang->t_lang = $language['langcode'];
                }

                foreach($this->translateAttributes as $field) {
                    if($field['label'] ==='t_translit'){
                        $this->updateMenuUrl($lang,$_POST['t_title'],$language['langcode']);
                        if(!empty($_POST['t_translit'][$language['langcode']])) {
                            $lang->t_translit = $_POST['t_translit'][$language['langcode']];
                        }elseif(isset($_POST['t_title'][$language['langcode']])) {
                            $lang->t_translit = Translit::cyrillicToLatin ($_POST['t_title'][$language['langcode']]);
                        } else
                            $lang->t_translit = null;
//                        $lang->t_translit = isset($_POST['t_title'])
//                            ? Translit::cyrillicToLatin ($_POST['t_title'][$language['langcode']])
//                            : null;
                    } else {
                        $lang->$field['label'] = isset($_POST[$field['label']][$language['langcode']])
                            ? $_POST[$field['label']][$language['langcode']]
                            : null;
                    }
                }
            $lang->save(false);
            }
        }

        parent::afterSave();
    }


    public static  function printULTree(){

        $criteria = new CDbCriteria;
        $criteria->with = array('translation');
        $criteria->condition = 'translation.t_lang=:lang';
        $criteria->params = array(':lang'=>Yii::app()->language);
        $categories = StaticPages::model()->findAll($criteria,array('order'=>'lft'));

        $level = 0;

        foreach($categories as $n=>$category)
        {
            if($category->level==$level)
                echo CHtml::closeTag('li')."\n";
            else if($category->level>$level)
                echo CHtml::openTag('ul')."\n";
            else
            {
                echo CHtml::closeTag('li')."\n";

                for($i=$level-$category->level;$i;$i--)
                {
                    echo CHtml::closeTag('ul')."\n";
                    echo CHtml::closeTag('li')."\n";
                }
            }
            echo CHtml::openTag('li',array('id'=>'node_'.$category->page_id,'rel'=>$category->translation->t_title));
              echo CHtml::openTag('a',array('href'=>$category->translation->t_translit));
            echo CHtml::encode($category->translation->t_title);
              echo CHtml::closeTag('a');

            $level=$category->level;
        }

        for($i=$level;$i;$i--)
        {
            echo CHtml::closeTag('li')."\n";
            echo CHtml::closeTag('ul')."\n";
        }
    }
        
    public function selectArray($grid = false)
    {
        $pageArray = Yii::app()->db->createCommand()
            ->select()
            ->from('static_pages')
            ->leftJoin('translate_pages','static_pages.page_id=translate_pages.page_id')
            ->where('translate_pages.t_lang=:lang',array(':lang'=>Yii::app()->language))
            ->order(array('static_pages.lft desc'))
            ->queryAll();

        $optionsArray = array();

        $level = 0;

        if(!empty($pageArray)){
            foreach ($pageArray as $key=>$page){
                if($grid)
                    $optionsArray[$page['page_id']] = str_repeat(' - ', $page['level']).$page['t_title'];
                else {
                    $pageText = "<option value=".$page['page_id'].">".str_repeat(' - ', $page['level']).$page['t_title']."</option>";
                    $optionsArray[$page['page_id']] = $pageText;
                }
            }
        }

        return $optionsArray;
    }

    public static function getLangDropdown()
    {
        $arr = array();
        foreach(Yii::app()->params['languages'] as $language)
        {
            $arr[$language['langcode']] = $language['lang'];
        }
        return $arr;
    }

}
<?php

/**
 * This is the model class for table "News".
 *
 * The followings are the available columns in table 'News':
 * @property integer $id
 * @property string $img
 * @property string $category
 */
class News extends CActiveRecord
{
    public $t_status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return 'News';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('category', 'required'),
//			array('img', 'length', 'max'=>255),
//            array('img','file','allowEmpty'=>true),
//			array('category', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, t_status', 'safe', 'on'=>'search'),
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
            'translation' => array(self::HAS_MANY, 'NewsTranslate', 't_id','index'=>'t_language'),
//            'attaches'=>array(self::HAS_MANY, 'Attachment', '',
//                ),
            'img'=>array(self::HAS_ONE, 'Attachment', 'entity_id'
            )
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'img' => 'Img',
			'category' => 'Category',
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

//        $criteria->with = ['translation'];
        $criteria->with = ['translation'=>['joinType'=>'left join','on'=>'translation.t_language=:lang','params'=>[':lang'=>Yii::app()->language]]];
        $criteria->together = true;
        $criteria->compare('translation.t_status',$this->t_status);
//        $criteria->compare('translation.t_language',$this->t_language);
		$criteria->compare('id',$this->id);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('category',$this->category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>[
                'route'=>Yii::app()->urlManager->createUrl('/backend/news/news/admin',array('language'=>Yii::app()->language)),
                'pageVar'=>'page',
                'params'=>isset($_GET['url']) ? ['url'=>urlencode($_GET['url']),'language'=>Yii::app()->language] : ['language'=>Yii::app()->language],
                'pagesize'=>25,
            ],
		));
	}

    public function afterDelete()
    {
        $sql = "delete from `NewsTranslate` where id not in (select `id` from `News`)";
        $result = Yii::app()->db->createCommand($sql)->execute();
        if($result) return parent::afterDelete();
        return false;
    }

    public function afterSave() {
        if($this->isNewRecord) {
            $languages = Yii::app()->params['languages'];

            foreach($languages as $language) {
                $lang = new NewsTranslate;
                $lang->t_id = $this->id;
                $lang->t_language = $language['langcode'];

                foreach($this->translateAttributes as $field) {
                    if($field['label']==='t_url') {
                        $phrase = isset($_POST['NewsTranslate']['t_url'][$language['langcode']])
                            ? $_POST['NewsTranslate']['t_url'][$language['langcode']]
                            : null;
                        $translit = NewsTranslate::model()->findByAttributes(array('t_url'=>$phrase))
                            ? $this->id.'-'.$phrase
                            : $phrase;
                        $lang->t_url = $translit;
                    } elseif ($field['label'] === 't_imgmeta')
                        $lang->t_imgmeta = serialize($_POST['NewsTranslate']['imgmeta']);
                    else {
                        $lang->$field['label'] = isset($_POST['NewsTranslate'][$field['label']][$language['langcode']])
                            ? $_POST['NewsTranslate'][$field['label']][$language['langcode']]
                            : null;
                    }
                }
                $lang->t_createdate = ($_POST['NewsTranslate']['t_createdate'][$language['langcode']] === '') ? null : $_POST['NewsTranslate']['t_createdate'][$language['langcode']];
                strtotime($lang->t_duedate);
                $lang->save(false);
            }
        } else {
            $languages = Yii::app()->params['languages'];

            foreach($languages as $language){
                $lang = NewsTranslate::model()->findByAttributes(
                    array(
                        't_id'=>$this->id,
                        't_language'=>$language['langcode']
                    )
                );
                if($lang === null){
                    $lang = new NewsTranslate;
                    $lang->t_id = $this->id;
                    $lang->t_language = $language['langcode'];
                }

                foreach($this->translateAttributes as $field) {
                    if($field['label'] === 't_imgmeta'){
                        $lang->t_imgmeta = serialize($_POST['NewsTranslate']['imgmeta']);
                    } elseif ($field['label'] !== 't_url') {
                        $lang->$field['label'] = isset($_POST['NewsTranslate'][$field['label']][$language['langcode']])
                            ? $_POST['NewsTranslate'][$field['label']][$language['langcode']]
                            : rand(0,102400);
                    } else {
                        $model = NewsTranslate::model()->findByAttributes(['t_url'=>$_POST['NewsTranslate']['t_url'][$language['langcode']]],'t_id!=:id',[':id'=>$this->id]);
                        $lang->t_url = (empty($model))
                            ? $_POST['NewsTranslate']['t_url'][$language['langcode']]
                            : $this->id.'-'.$_POST['NewsTranslate']['t_url'][$language['langcode']];
                    }
                }

                $lang->t_createdate = ($_POST['NewsTranslate']['t_createdate'][$language['langcode']] === '0000-00-00 00:00:00') ? null : $_POST['NewsTranslate']['t_createdate'][$language['langcode']];
                strtotime($lang->t_duedate);
                $lang->save(false);
            }
        }

        parent::afterSave();
    }

    public function behaviors()
    {
        return array(
            'AttachmentBehavior'=>array(
                'class'=>'application.backend.modules.attach.components.AttachmentBehavior',
//                'entity_id'=>$this->id,
                'relationName'=>'id',
                'upload_path'=>Yii::getPathOfAlias('webroot').'/uploads/',
            ),
            'Multilanguage'=>array(
                'class'=>'application.backend.modules.news.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                    't_title'=>array(
                        'label'=>'t_title',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge translate'
                        ),
                    ),
                    't_shorttext'=>array(
                        'label'=>'t_shorttext',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
//                            'class'=>'tinyEditor'
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_url'=>array(
                        'label'=>'t_url',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge url',
                            'disabled'=>true,
                        ),
                    ),
                    't_fulltext'=>array(
                        'label'=>'t_fulltext',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'tinyEditor'
                        ),
                    ),

                    't_status'=>array(
                        'label'=>'t_status',
                        'fieldType'=>'dropDownList',
                        'value'=>['draft'=>'draft','published'=>'published','archive'=>'archive'],
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_createdate'=>array(
                        'label'=>'t_createdate',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge date'
                        ),
                    ),
                    't_duedate'=>array(
                        'label'=>'t_duedate',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge date'
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
                    't_mdescription'=>array(
                        'label'=>'t_mdescription',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_mkeywords'=>array(
                        'label'=>'t_mkeywords',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
//                    't_imgmeta'=>array(
//                        'label'=>'t_imgmeta',
//                        'fieldType'=>'dropDownList',
//                        'value'=>['imgalt'=>'imgalt','imgtitle'=>'imgtitle'],
//                        'htmlOptions'=>array(
//                            'class'=>'input-xxlarge imgmeta'
//                        ),
//                    ),
                ),
            ),
        );
    }

}
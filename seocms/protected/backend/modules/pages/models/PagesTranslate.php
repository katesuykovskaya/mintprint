<?php
class PagesTranslate extends CActiveRecord
{
    public $published;
    public $level;
    public $image;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagesTranslate the static model class
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
		return 'translate_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, t_lang', 'required'),
			array('page_id', 'numerical', 'integerOnly'=>true),
            array('img', 'file', 'types'=>'jpg, jpeg, gif, png','allowEmpty'=>true),
			array('t_lang', 'length', 'max'=>2),
			//array('t_desc, t_h1, tm_title, tm_desc, tm_keywords', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        
            array('id, page_id, t_lang, t_title, t_desc, t_h1, t_content, t_mtitle, t_mdesc, t_mkeywords, t_translit', 'safe', 'on'=>'insert, update'),
			array('id, published, page_id, t_lang, t_title, t_desc, t_h1, t_content, t_mtitle, t_mdesc, t_mkeywords, level', 'safe', 'on'=>'search'),
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
            'page'=>array(self::BELONGS_TO,'StaticPages','page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            't_title'=>'Тайтл страницы',
			'page_id' => 'Page',
			't_lang' => 'T Lang',
			't_desc' => 'T Desc',
			't_h1' => 'T H1',
			't_content' => 'T Content',
			't_mtitle' => 'Tm Title',
			't_mdesc' => 'Tm Desc',
			't_mkeywords' => 'Tm Keywords',
            'published'=>'Опубликована',
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
                $criteria->with=array('page'=>array(
                    'joinType'=>'LEFT JOIN'
                ));
            if($this->level)
            {
                $root = StaticPages::model()->findByPk((int)$this->level);

                $connection = Yii::app()->db;
                $sql = 'select max(level) as level from static_pages where lft>='.$root->lft.' AND rgt<='.$root->rgt;
                $command = $connection->createCommand($sql);
                $max = $command->queryScalar();


                if($root->level == $max){
                    $criteria->condition = 'page.lft=:lft AND page.rgt=:rgt AND page.level=:level';
                    $criteria->params = array(':lft'=>$root->lft, ':rgt'=>$root->rgt,':level'=>$root->level);
                }
                else{
                    $criteria->condition = 'page.lft>:lft AND page.rgt<:rgt AND page.level=:level';
                    $criteria->params = array(':lft'=>$root->lft, ':rgt'=>$root->rgt,':level'=>$root->level+1);
                }
            }

        $criteria->compare('published',$this->published);
        $criteria->compare('t_title',$this->t_title,true);
        $criteria->compare('id',$this->id);
        $criteria->compare('page_id',$this->page_id,true);
        $criteria->compare('t_lang', $this->t_lang);
        $criteria->compare('t_desc',$this->t_desc,true);
        $criteria->compare('t_h1',$this->t_h1,true);
        $criteria->compare('t_content',$this->t_content,true);
        $criteria->compare('t_mtitle',$this->t_mtitle,true);
        $criteria->compare('t_mdesc',$this->t_mdesc,true);
        $criteria->compare('t_mkeywords',$this->t_mkeywords,true);


        $criteria->order = 'lft';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'route'=>Yii::app()->urlManager->createUrl('backend/pages/pages/grid',array('language'=>Yii::app()->language)),
                            'pageVar'=>'page',
                            'params'=>isset($_GET['url']) ? array('url'=>urlencode($_GET['url'])) : array(),
                            'pagesize'=>25,
                        ),
                        
//                        'sort'=>array(
//                            'route'=>'pages/pages/grid',
//                          ),
		));
	}

    public static function getIdByUrl($url)
    {
        $model = self::model()->findByAttributes(array('t_translit'=>$url,'t_lang'=>Yii::app()->language));
        if(!isset($model))
            Yii::app()->user->setFlash('error_message',Yii::t('backend','Данный URL не принадлежит ни одной из страниц!
            Попробуйте обновить данные.'));
        return isset($model->page_id) ? $model->page_id : null;
    }

    public function behaviors()
    {
        return array(
            'Multilanguage'=>array(
                'class'=>'application.backend.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                    't_title'=>array(
                        'label'=>'t_title',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                    't_desc'=>array(
                        'label'=>'t_desc',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                    't_h1'=>array(
                        'label'=>'t_h1',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
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
                        ),
                    ),
                    't_mtitle'=>array(
                        'label'=>'t_mtitle',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                    't_mdesc'=>array(
                        'label'=>'t_mdesc',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                    't_mkeywords'=>array(
                        'label'=>'t_mkeywords',
                        'fieldType'=>'textArea',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                ),
            ),
        );
    }
}
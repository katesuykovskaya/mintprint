<?php

/**
 * This is the model class for table "NewsTranslate".
 *
 * The followings are the available columns in table 'NewsTranslate':
 * @property integer $t_id
 * @property string $t_language
 * @property string $t_title
 * @property string $t_shorttext
 * @property string $t_fulltext
 * @property string $t_url
 * @property string $t_status
 * @property string $t_mtitle
 * @property string $t_mdescription
 * @property string $t_mkeywords
 * @property string $t_imgmeta
 * @property string $t_createdate
 * @property string $t_duedate
 */
class NewsTranslate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NewsTranslate the static model class
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
		return 'NewsTranslate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('t_language, t_title, t_shorttext, t_fulltext, t_url, t_mtitle, t_mdescription, t_mkeywords, t_imgmeta, t_createdate', 'required'),
			array('t_language', 'length', 'max'=>2),
			array('t_title, t_url, t_mtitle, t_mdescription, t_mkeywords', 'length', 'max'=>255),
			array('t_status', 'length', 'max'=>9),
			array('t_duedate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('t_id, t_language, t_title, t_shorttext, t_fulltext, t_url, t_status, t_mtitle, t_mdescription, t_mkeywords, t_imgmeta, t_createdate, t_duedate', 'safe', 'on'=>'search'),
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
            'news'=>[self::BELONGS_TO,'News',['t_id'=>'id'], 'joinType'=>"LEFT JOIN"],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			't_id' => 'T',
			't_language' => 'tlang',
			't_title' => 'T Title',
			't_shorttext' => 'T Shorttext',
			't_fulltext' => 'T Fulltext',
			't_url' => 'T Url',
			't_status' => 'T Status',
			't_mtitle' => 'T Mtitle',
			't_mdescription' => 'T Mdescription',
			't_mkeywords' => 'T Mkeywords',
			't_imgmeta' => 'T Imgmeta',
			't_createdate' => 'T Createdate',
			't_duedate' => 'T Duedate',
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

		$criteria->compare('t_id',$this->t_id);
		$criteria->compare('t_language',$this->t_language,true);
		$criteria->compare('t_title',$this->t_title,true);
		$criteria->compare('t_shorttext',$this->t_shorttext,true);
		$criteria->compare('t_fulltext',$this->t_fulltext,true);
		$criteria->compare('t_url',$this->t_url,true);
		$criteria->compare('t_status',$this->t_status,true);
		$criteria->compare('t_mtitle',$this->t_mtitle,true);
		$criteria->compare('t_mdescription',$this->t_mdescription,true);
		$criteria->compare('t_mkeywords',$this->t_mkeywords,true);
		$criteria->compare('t_imgmeta',$this->t_imgmeta,true);
		$criteria->compare('t_createdate',$this->t_createdate,true);
		$criteria->compare('t_duedate',$this->t_duedate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
//                        'value'=>$this->isNewRecord ? ['2'=>'draft','1'=>'published','3'=>'archive'] : $this->t_status,
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
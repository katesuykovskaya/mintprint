<?php

/**
 * This is the model class for table "SliderTranslate".
 *
 * The followings are the available columns in table 'SliderTranslate':
 * @property integer $id
 * @property integer $t_id
 * @property string $t_blockquote
 * @property string $t_cite
 * @property string $t_language
 * @property string $t_href
 */
class SliderTranslate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SliderTranslate the static model class
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
		return 'SliderTranslate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('t_id, t_desc, t_href, t_language', 'required'),
			array('t_id', 'numerical', 'integerOnly'=>true),
			array('t_desc, t_href', 'length', 'max'=>255),
//            array('t_href', 'url'),
			array('t_language', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, t_id, t_desc, t_language, t_href',  'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			't_id' => 'T',
			't_desc' => 'Описание',
            't_href' => 'Ссылка',
			't_language' => 'Язык',
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
		$criteria->compare('t_id',$this->t_id);
		$criteria->compare('t_desc',$this->t_desc,true);
        $criteria->compare('t_href',$this->t_href,true);
		$criteria->compare('t_language',$this->t_language,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
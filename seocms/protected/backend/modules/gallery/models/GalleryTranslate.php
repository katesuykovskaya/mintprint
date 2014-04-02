<?php

/**
 * This is the model class for table "GalleryTranslate".
 *
 * The followings are the available columns in table 'GalleryTranslate':
 * @property integer $id
 * @property integer $t_id
 * @property string $t_language
 * @property string $t_title
 * @property string $t_file
 * @property string $t_fileType
 * @property string $t_meta
 * @property string $t_createdate
 */
class GalleryTranslate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GalleryTranslate the static model class
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
		return 'GalleryTranslate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('t_id, t_language, t_title, t_file, t_fileType, t_meta, t_createdate', 'required'),
			array('t_id', 'numerical', 'integerOnly'=>true),
			array('t_language', 'length', 'max'=>2),
			array('t_title, t_file', 'length', 'max'=>255),
			array('t_fileType', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, t_id, t_language, t_title, t_file, t_fileType, t_meta, t_createdate', 'safe', 'on'=>'search'),
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
            'gallery'=>[self::BELONGS_TO,'Gallery',['t_id'=>'id']],
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
			't_lang' => 'T Language',
			't_title' => 'T Title',
			't_file' => 'T File',
			't_fileType' => 'T File Type',
			't_meta' => 'T Meta',
			't_createdate' => 'T Createdate',
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
		$criteria->compare('t_lang',$this->t_lang,true);
		$criteria->compare('t_title',$this->t_title,true);
		$criteria->compare('t_file',$this->t_file,true);
		$criteria->compare('t_fileType',$this->t_fileType,true);
		$criteria->compare('t_meta',$this->t_meta,true);
		$criteria->compare('t_createdate',$this->t_createdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
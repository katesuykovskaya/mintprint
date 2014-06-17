<?php

/**
 * This is the model class for table "CapTranslate".
 *
 * The followings are the available columns in table 'CapTranslate':
 * @property integer $id
 * @property integer $t_id
 * @property string $t_blockquote
 * @property string $t_cite
 * @property string $t_language
 */
class CapTranslate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CapTranslate the static model class
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
		return 'CapTranslate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('t_id, t_blockquote, t_cite, t_language', 'required'),
			array('t_id', 'numerical', 'integerOnly'=>true),
			array('t_cite', 'length', 'max'=>255),
			array('t_language', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, t_id, t_blockquote, t_cite, t_language', 'safe', 'on'=>'search'),
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
			't_blockquote' => Yii::t('backend', 'Цитата'),
			't_cite' => Yii::t('backend', 'Автор'),
			't_language' => 'T Language',
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
		$criteria->compare('t_blockquote',$this->t_blockquote,true);
		$criteria->compare('t_cite',$this->t_cite,true);
		$criteria->compare('t_language',$this->t_language,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
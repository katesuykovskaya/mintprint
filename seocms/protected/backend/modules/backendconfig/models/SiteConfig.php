<?php

/**
 * This is the model class for table "SiteConfig".
 *
 * The followings are the available columns in table 'SiteConfig':
 * @property integer $id
 * @property string $param
 * @property string $value
 * @property string $default
 * @property string $label
 * @property string $type
 * @property string $data_type
 * @property string $status
 * @property string $position
 */
class SiteConfig extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteConfig the static model class
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
		return 'SiteConfig';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('param, value, default, label, data_type,status,type', 'required'),
			array('param, label, type', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, param, value, default, label, data_type, position,type', 'safe', 'on'=>'search'),
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
			'param' => 'Param',
			'value' => 'Value',
			'default' => 'Default',
			'label' => 'Label',
			'type' => 'Type',
            'data_type'=>'Data Type'
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
		$criteria->compare('param',$this->param,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('default',$this->default,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('type',$this->type,true);
        $criteria->compare('data_type',$this->data_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
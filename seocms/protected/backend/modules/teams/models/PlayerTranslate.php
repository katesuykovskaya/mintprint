<?php

/**
 * This is the model class for table "PlayersTranslate".
 *
 * The followings are the available columns in table 'PlayersTranslate':
 * @property integer $t_id
 * @property string $t_language
 * @property string $t_fio
 * @property string $t_country
 */
class PlayerTranslate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PlayerTranslate the static model class
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
		return 'PlayersTranslate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('t_id, t_language, t_fio, t_country', 'required'),
			array('t_id', 'numerical', 'integerOnly'=>true),
			array('t_language', 'length', 'max'=>2),
			array('t_fio, t_country', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('t_id, t_language, t_fio, t_country', 'safe', 'on'=>'search'),
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
            'player'=>array(self::BELONGS_TO,'Player','t_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			't_id' => 'T',
			't_language' => 'T Language',
			't_fio' => 'ФИО',
			't_country' => 'Страна',
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
		$criteria->compare('t_fio',$this->t_fio,true);
		$criteria->compare('t_country',$this->t_country,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function behaviors() {
        return array(
            'Multilanguage'=>array(
                'class'=>'application.backend.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                    't_fio'=>array(
                        'label'=>'t_fio',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                    't_country'=>array(
                        'label'=>'t_country',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                ),
            ),
        );
    }
}
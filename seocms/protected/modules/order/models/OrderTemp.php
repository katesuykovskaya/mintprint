<?php

/**
 * This is the model class for table "OrderTemp".
 *
 * The followings are the available columns in table 'OrderTemp':
 * @property integer $id
 * @property integer $session_id
 * @property integer $user_id
 * @property string $img_url
 * @property string $thumb_url
 * @property integer $img_count
 * @property integer $img_width
 * @property integer $img_height
 * @property integer $img_x
 * @property integer $img_y
 */
class OrderTemp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderTemp the static model class
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
		return 'OrderTemp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('img_url, thumb_url', 'required'),
			array('user_id, img_count, img_width, img_height, img_x, img_y', 'numerical', 'integerOnly'=>true),
			array('img_url, thumb_url', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, session_id, user_id, img_url, thumb_url, img_count, img_width, img_height, img_x, img_y', 'safe', 'on'=>'search'),
            array('type', 'in', 'range'=>array('social', 'upload'), 'allowEmpty' => true),
            array('type', 'default', 'value'=>'social')
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
			'session_id' => 'Session',
			'user_id' => 'User',
			'img_url' => 'Img Url',
			'thumb_url' => 'Thumb Url',
			'img_count' => 'Img Count',
			'img_width' => 'Img Width',
			'img_height' => 'Img Height',
			'img_x' => 'Img X',
			'img_y' => 'Img Y',
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
		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('thumb_url',$this->thumb_url,true);
		$criteria->compare('img_count',$this->img_count);
		$criteria->compare('img_width',$this->img_width);
		$criteria->compare('img_height',$this->img_height);
		$criteria->compare('img_x',$this->img_x);
		$criteria->compare('img_y',$this->img_y);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave() {
        if($this->isNewRecord) {
            $this->session_id = Yii::app()->session->sessionID;
            if(!Yii::app()->user->isGuest && !empty(Yii::app()->user->id))
                $this->user_id = Yii::app()->user->id;
            $this->img_count = 1;
            $size = getimagesize($this->img_url);
            $w = $size[0]; $h = $size[1];
            if($w >= $h) {
                $this->img_height = $h;
                $this->img_width = $h;
                $this->img_x = ($w - $h) / 2;
                $this->img_y = 0;
            } else {
                $this->img_height = $w;
                $this->img_width = $w;
                $this->img_y = ($h - $w) / 2;
                $this->img_x = 0;
            }
            return true;
        }
        return true;
    }
}
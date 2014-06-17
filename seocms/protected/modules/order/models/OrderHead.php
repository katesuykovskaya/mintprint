<?php

/**
 * This is the model class for table "OrderHead".
 *
 * The followings are the available columns in table 'OrderHead':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $region
 * @property string $delivery
 * @property string $newPostAddress
 * @property integer $sign
 * @property integer $price
 */
class OrderHead extends CActiveRecord
{
    public $photoCount;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderHead the static model class
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
		return 'OrderHead';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, status, email, phone, address, city, region, newPostAddress', 'required'),
			array('sign', 'numerical', 'integerOnly'=>true),
			array('name, email, address, region, newPostAddress', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>60),
            array('status', 'in', 'range'=>array('new','ready', 'shipped', 'delete')),
			array('city', 'length', 'max'=>128),
			array('delivery', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, photoCount, status, name, email, phone, address, city, region, delivery, newPostAddress, sign, price', 'safe', 'on'=>'search'),
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
            'body'=>array(self::HAS_MANY, 'OrderBody', 'id_order'),
            'count'=>array(self::STAT, 'OrderBody', 'id_order')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'email' => 'Email',
			'phone' => 'Phone',
			'address' => 'Address',
			'city' => 'City',
			'region' => 'Region',
			'delivery' => 'Delivery',
			'newPostAddress' => 'New Post Address',
			'sign' => 'Sign',
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
//        die(print_r($_REQUEST));
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->select = 't.*, COUNT(OrderBody.id) AS `count`';
        $criteria->join = "INNER JOIN `OrderBody` ON `t`.`id` = `OrderBody`.`id_order`";
        $criteria->group = 't.id';
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('delivery',$this->delivery,true);
		$criteria->compare('newPostAddress',$this->newPostAddress,true);
		$criteria->compare('sign',$this->sign);
        $criteria->compare('price',$this->price);
        $criteria->compare('status',$this->status);
        if($this->photoCount)
        {
            $criteria->having = "`count` = {$this->photoCount}";
        }




		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'photoCount'=>array(
                        'asc'=>'count',
                        'desc'=>'count DESC',
                    ),
                    '*',
                ),
            ),
		));
	}
}
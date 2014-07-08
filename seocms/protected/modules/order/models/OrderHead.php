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
 * @property integer $date
 * @property strinf $index
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
			array('name, status, email, phone, address, city, region, index', 'required'),
			array('sign, index', 'numerical', 'integerOnly'=>true),
			array('name, email, address, region', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>60),
            array('status', 'in', 'range'=>array('new','ready', 'shipped', 'delete')),
			array('city', 'length', 'max'=>128),
			array('delivery', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, photoCount, status, name, email, phone, address, city, region, delivery, sign, price, date, index', 'safe', 'on'=>'search'),
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
			'name' => 'Имя и Фамилия',
			'email' => 'Email',
			'phone' => 'Телефон',
			'address' => 'Адрес',
			'city' => 'Город',
			'region' => 'Область',
			'delivery' => 'Способ доставки',
			'newPostAddress' => 'New Post Address',
			'sign' => 'Подписан на новости',
            'date' => 'Дата',
            'photoCount' => 'Кол-во фото',
            'price'=>'Сумма'
		);
	}

    public function afterDelete()
    {
        $sql = "DELETE FROM OrderBody WHERE id_order = ".$this->id;
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $result = $command->execute();
        if($result){
            $this->cleanAndDeleteDir(Yii::getPathOfAlias('webroot').'/uploads/Order/'.$this->id);
            $this->cleanAndDeleteDir(Yii::getPathOfAlias('webroot').'/uploads/Order/thumb/'.$this->id);
        }
    }

    public function cleanAndDeleteDir($dir) {
        $files = glob($dir."/*");
        $c = count($files);
        if (count($files) > 0) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        rmdir($dir);
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
        $criteria->compare('date', $this->date);
        $criteria->compare('index', $this->index);
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
            'pagination'=>array(
                'pageSize'=>20,
                'route'=>Yii::app()->createUrl('backend/order/order/admin'),
                'pageVar'=>'page',
                'params'=>isset($_GET['page']) ? array('page'=>$_GET['page']): array()
            )
		));
	}
}
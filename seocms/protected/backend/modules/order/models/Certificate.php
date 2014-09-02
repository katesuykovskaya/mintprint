<?php

/**
 * This is the model class for table "Certificate".
 *
 * The followings are the available columns in table 'Certificate':
 * @property integer $id
 * @property integer $code
 * @property integer $id_order
 * @property string $create_date
 * @property string $due_date
 * @property integer $limit
 */
class Certificate extends CActiveRecord
{
    public $status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Certificate the static model class
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
		return 'Certificate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, create_date, due_date, limit', 'required'),
			array('code, id_order, limit', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, id_order, create_date, due_date, status, limit', 'safe', 'on'=>'search'),
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
            'order'=>array(self::BELONGS_TO, 'OrderHead', 'id_order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Код сертификата',
			'id_order' => 'Id Заказа',
			'create_date' => 'Дата Создания',
			'due_date' => 'Дата Истечения',
            'limit'=>'Ограничение по сумме заказа'
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
		$criteria->compare('code',$this->code, true);
		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('due_date',$this->due_date,true);
        $criteria->compare('`limit`',$this->limit, false);

        if($this->status)
        {
            switch($this->status)
            {
                case 'used':
                    $criteria->addCondition('t.id_order IS NOT NULL');
                    break;
                case 'overdue':
                    $criteria->addCondition('t.id_order IS NULL');
                    $criteria->addCondition('DATEDIFF(NOW(), t.due_date) > 1');
                    break;
                case 'new':
                    $criteria->addCondition('t.id_order IS NULL');
                    $criteria->addCondition('DATEDIFF(NOW(), t.due_date) <= 1');
                    break;
            }
        }

        $params = array();
        if(!empty($_GET['page'])) $params['page'] = $_GET['page'];
        if(!empty($_GET['Certificate']['code'])) $params['Certificate']['code'] = $_GET['Certificate']['code'];
        if(!empty($_GET['Certificate']['id_order'])) $params['Certificate']['id_order'] = $_GET['Certificate']['id_order'];
        if(!empty($_GET['Certificate']['create_date'])) $params['Certificate']['create_date'] = $_GET['Certificate']['create_date'];
        if(!empty($_GET['Certificate']['due_date'])) $params['Certificate']['due_date'] = $_GET['Certificate']['due_date'];
        if(!empty($_GET['Certificate']['status'])) $params['Certificate']['status'] = $_GET['Certificate']['status'];
        if(!empty($_GET['Certificate']['limit'])) $params['Certificate']['limit'] = $_GET['Certificate']['limit'];

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'route'=>Yii::app()->createUrl('backend/order/certificate/admin'),
                'pageVar'=>'page',
                'params'=>$params,
                'pageSize'=>30,
            ),
		));
	}

    public function getStatus($o)
    {
        if($o->id_order) return "Использован";
        if(strtotime($o->due_date) < strtotime(date("Y-m-d", time()))) return "Прострочен";
        return "Новый";
    }
}
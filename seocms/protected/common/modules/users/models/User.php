<?php
/**
 * This is the model class for table "seotm_users".
 *
 * @property string $role
 * @property int $user_id
 * @property string $login
 * @property string $email
 * @property string $status
 *
 */
class User extends CActiveRecord
{
	/* массив для хранения екшенов к которым у юзера разрешен доступ */
    public $itemsArr = array();
    /* переменная для хранения роли, чтобы назначать/изменять юзеру через формы*/
    public $role;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'seotm_users';
	}

        protected function afterValidate()
        {
            $this->pass = $this->encrypt($this->pass);
            return parent::afterValidate();
        }
 
        public function encrypt($value)
        {
            $enc = NEW bCrypt();
            return $enc->hash($value);
        }
        
	public function rules()
	{
		return array(
			array('login, email', 'required','on'=>'insert'),
            array('login','unique'),
//            array('last_action_time, reg_date, last_login,email, pass, login, user_id,login_numbs', 'safe','on'=>'update'),
//            array('pass','required','on'=>'activate'),
            array('reg_date, last_login, role, token','safe'),
			//array('u_group_id, user_counter', 'numerical', 'integerOnly'=>true),
			//array('role', 'length', 'max'=>32),
//            array('email','required','on'=>'insert'),
            array('email','email'),
			array('login', 'length', 'max'=>64),
			array('pass', 'length', 'max'=>255),
			//array('active', 'length', 'max'=>7),
			//array('login_multi_use', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, email, role, login, pass, last_login,last_action_time,', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'u_group_id' => 'U Group',
			'role' => 'Role',
			'login' => 'Login',
			'pass' => 'Pass',
			'salt' => 'Salt',
			'enrol_date' => 'Enrol Date',
			'last_login' => 'Last Login Time',
			'user_counter' => 'User Counter',
			'active' => 'Active',
			'login_multi_use' => 'Login Multi Use',
			'email' => 'Email',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

		$criteria=new CDbCriteria;

        if(Yii::app()->user->role !== Yii::app()->params['admin']){
            $criteria->addCondition('role!=:role','AND');
            $criteria->params = array(':role'=>Yii::app()->params['admin']);
        }
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pass',$this->pass,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public static function getUsers()
        {  
        $arr = User::model()->findAll();
        $users = CHtml::listData($arr,'user_id','login');
           
        return CHtml::dropDownList('user','',$users);
        }
        
        /* вывод всех ролей конкретного пользователя*/
        public function getRole($id)
        {
            $roles = array();
            if(Yii::app()->user->role !== Yii::app()->params['admin'])
                $model = AuthAssignment::model()->findAllByAttributes(array('userid'=>$id));
            else {
                $criteria = new CDbCriteria;
                $criteria->condition = array('user_id=:id AND itemname = :adminRole');
                $criteria->params = array(':id'=>$id,':adminRole'=>Yii::app()->params['admin']);
                $model = AuthAssignment::model()->findAllByAttributes(array('userid'=>$id));
            }


            foreach ($model as $role)
            {
                if(!empty($role->itemname)) {
                        $roles[] = CHtml::link($role->itemname, Yii::app()->urlManager->createUrl('users/users/permissions'));
                } else {
                    $roles[] = 'not assigned';
                }
            }
            return implode(', ',$roles);
        }

        /* get all roles - вывод всех ролей*/
        public function getRoles()
        {
            $model = AuthItem::model()->findAll(array('condition'=>('type=2')));
            $arr = array();
            foreach($model as $key=>$value)
                if($value->name!='admin')
                    $arr[$value->name]=$value->name;
            return $arr;
        }
        
        /* отдаёт массив всех екшенов */
        public function getAllActions()
        {
                $criteria = new CDbCriteria;
                $criteria->condition = 'type!=2';
                $all = AuthItem::model()->findAll($criteria);
                return $all;   
        }
        

        /* метод отдаёт массив пользователей и их прав, для построения таблицы прав по ролям*/
        
        public function getAllAssignments()
        {

             $connection = Yii::app()->db;
             $sql = 'select name from AuthItem where type=2';
             $command = $connection->createCommand($sql);
             $roles = $command->queryAll();

             $sqlall = 'select name, child from AuthItem inner join AuthItemChild on AuthItem.name=AuthItemChild.parent where type=2 order by name';
             $command2 = $connection->createCommand($sqlall);
             $childArray = $command2->queryAll();

             $newArr = array();

             $pattern ='^[a-z,A-Z]\.[a-z,A-Z]?^';

             foreach ($childArray as $child)
             {
                 if(preg_match($pattern, $child['child']))
                                {
                                $newArr[$child['name']][] = $child['child'];
                                } else {
                                    $childrenArray = array();
                                    $newArr[$child['name']] = $this->roleChildren($child['name'], $childrenArray); 
                                }
             }
             return $newArr; 
        }


        protected function roleChildren($role, $childrenArray = array())
        {

            $connection = Yii::app()->db;
            $roleSql = 'select child from AuthItemChild where parent=:parent';
            $command = $connection->createCommand($roleSql);
            $command->bindParam(':parent', $role);
            $result = $command->queryAll();

            $pattern ='^[a-z,A-Z]\.[a-z,A-Z]?^';

            foreach ($result as $action)
            {
                if(preg_match($pattern, $action['child']))
                {
                    $childrenArray[$role][] = $action['child'];
                } else {
                    $childrenArray = $this->roleChildren($action['child'], $childrenArray);
                }
            }

            $someArr = array();
                $new = $this->mixArray($childrenArray, $someArr);

            return $new;

        }

      /*рекурсивный проход по массиву с целью создания одномерного*/
        protected function mixArray($val, $new = array())
        {
            if(is_array($val))
            {
                foreach ($val as $key=>$value)
                {
                    if(is_array($value))
                        $new = $this->mixArray ($value,$new);
                    else
                       $new[] = $value;
                }
            } else {
                $new[] = $val;
            }
        return $new;
        }


        public function getOnline(){
            return ((strtotime($this->last_action_time) + 600 ) > time()) ? true : false;
        }

    protected  function beforeSave()
    {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->reg_date = date('Y-m-d H:i:s');
                return true;
            }
            else {
                // если стоит иф-елс, для елса обязательно возвращать тру,
                // иначе не будут сохранения не нью рекордз работать*/
                return true;
            }
        } else {
            return false;
        }

    }


    public function onCreate($event)
    {
        // Непосредственно вызывать событие принято в его описании.
        // Это позволяет использовать данный метод вместо raiseEvent
        // во всём остальном коде.
        $this->raiseEvent('onCreate', $event);
    }

    public function onRenewPassword($event)
    {
        // Непосредственно вызывать событие принято в его описании.
        // Это позволяет использовать данный метод вместо raiseEvent
        // во всём остальном коде.
        $this->raiseEvent('onRenewPassword', $event);
    }
}
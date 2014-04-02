<?php

/**
 * This is the model class for table "usermenu".
 *
 * The followings are the available columns in table 'usermenu':
 * @property integer $id
 * @property string $text
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property integer $url
 */
class Usersmenu extends CActiveRecord
{

    const ADMIN_TREE_CONTAINER_ID='usermenu_admin_tree';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usermenu the static model class
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
		return 'usermenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('text, lft, rgt, lvl, url', 'required'),
//			array('lft, rgt, lvl, url', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, text, lft, rgt, lvl, url', 'safe', 'on'=>'search'),
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
			'text' => 'Text',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'lvl' => 'Lvl',
			'url' => 'Url',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('lvl',$this->lvl);
		$criteria->compare('url',$this->url);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
    {
        return array(
            'NestedSetBehavior'=>array(
                'class'=>'application.backend.components.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
                'hasManyRoots'=>true,
            )
        );
    }

    public static  function printULTree()
    {
        $role = isset($_POST['role']) ? $_POST['role'] : null;
        $connection = Yii::app()->db;
        $sql = "select * from usermenu where role=:role AND visible ='1' order by root,lft";
        $command = $connection->createCommand($sql);
        $command->bindParam(':role',$role,PDO::PARAM_STR);
        $categories = $command->queryAll();
        $level=0;

        foreach($categories as $n=>$category)
        {
            if($category['level']==$level)
                echo CHtml::closeTag('li')."\n";
            else if($category['level']>$level)
                echo CHtml::openTag('ul')."\n";
            else
            {
                echo CHtml::closeTag('li')."\n";

                for($i=$level-$category['level'];$i;$i--)
                {
                    echo CHtml::closeTag('ul')."\n";
                    echo CHtml::closeTag('li')."\n";
                }
            }
            echo CHtml::openTag('li',array('id'=>'node_'.$category['id'],'rel'=>$category['text']));
            echo CHtml::openTag('a',array('href'=>$category['url']));
            echo CHtml::encode(Yii::t('backend',$category['text']));
            echo CHtml::closeTag('a');

            $level=$category['level'];
        }

        for($i=$level;$i;$i--)
        {
            echo CHtml::closeTag('li')."\n";
            echo CHtml::closeTag('ul')."\n";
        }
    }

    public static function getButtons($role)
    {
        $model = Usersmenu::model()->findAllByAttributes(array('role'=>$role));
        if(!empty($model))
        {
           $buttons = CHtml::submitButton(Yii::t('backend','Редактировать'),array('class'=>'btn','name'=>'Edit')).
                      CHtml::submitButton(Yii::t('backend','Удалить'),array('class'=>'btn','name'=>'Delete','confirm'=>Yii::t('backend','Удалить?')));
        } else {
            $buttons = CHtml::submitButton(Yii::t('backend','Создать'),array('class'=>'btn','name'=>'Create'));
        }
        return $buttons;
    }
}
<?php

/**
 * This is the model class for table "SourceMessage".
 *
 * The followings are the available columns in table 'SourceMessage':
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * The followings are the available model relations:
 * @property Message[] $messages
 */
class SourceMessage extends CActiveRecord
{
    /* needs to be to show in related grid */
    public $related;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SourceMessage the static model class
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
		return 'SourceMessage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('id', 'required'),
            array('category, message','required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('category', 'length', 'max'=>32),
			array('message', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category, message', 'safe', 'on'=>'search'),
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
			'messages' => array(self::HAS_MANY, 'Message', 'id','index'=>'language'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => 'Category',
			'message' => 'Message',
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
		$criteria->compare('category',$this->category, true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'route'=>Yii::app()->urlManager->createUrl('backend/multilanguage/source/admin',array('language'=>Yii::app()->language)),
                'params'=>isset($_GET['url']) ? array('url'=>urlencode($_GET['url']),'language'=>Yii::app()->language) : array('language'=>Yii::app()->language),
                'pageVar'=>'page',
                'pagesize'=>20,
            ),
		));
	}

    public function getCategoryList()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'category';
        $criteria->distinct = true;

        return CHtml::listData($this->findAll($criteria),'category','category');
    }

    public function afterSave()
    {
        $languages = Yii::app()->params['languages'];

        if($this->isNewRecord)
        {
            foreach($languages as $language)
            {
                $translation = new Message();
                $translation->id = $this->id;
                $translation->language = $language['langcode'];
                $translation->translation = !empty($_POST['SourceMessage'][$language['langcode']]) ?  $_POST['SourceMessage'][$language['langcode']] : '--No translation--';
                $translation->save(false);
            }
        } else {
            foreach($languages as $language)
            {
                    $translation = Message::model()->findByAttributes(array('id'=>$this->id,'language'=>$language['langcode']));
                    if(!$translation)
                    $translation = new Message;
                    $translation->id = $this->id;
                    $translation->language = $language['langcode'];
                    $translation->translation = $_POST['SourceMessage'][$language['langcode']];
                    $translation->save(false);
            }
        }

        parent::afterSave();
    }

    public static function getFlagImage($langCode){

        if(isset(Yii::app()->params->languages[$langCode])){
            $image = CHtml::image('/img/icons/flags/16/'.Yii::app()->params->languages[$langCode]['countrycode'].'.png',
                                    Yii::t('backend','Флаг страны')).' '.Yii::app()->params->languages[$langCode]['lang'];
            return $image;
        } else {
            return Yii::t('backend','Язык не используется проектом');
        }

    }

}
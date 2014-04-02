<?php

/**
 * This is the model class for table "Feedback".
 *
 * The followings are the available columns in table 'feedback':
 * @property integer $id
 * @property string $sender_mail
 * @property string $sender_name
 * @property string $subject
 * @property string $site
 * @property string $body
 * @property string $files
 * @property string $ip
 * @property string $phone
 * @property string $create_date
 */
class Feedback extends CActiveRecord
{
    public $mailheader;
    public $mailfooter;
    public $charset;
    public $adminEmail;
    public $mailGroup;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feedback the static model class
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
		return 'Feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
			return array(
                array('sender_name, sender_mail, body', 'required'),
                array('sender_mail, phone','mailOrPhone'),
                array('sender_mail','email'),
//                array('phone','match','pattern'=>'/^[\d-() \+]{5,}?$/','message'=>Yii::t('frontend',
//                    'Номер телефона может содержать: цыфры 0-9, "+", "-", "(", ")"
//                    и символ пробела и состоит не меньше чем из 5-ти цыфр!')),
                array('files, ip, create_date, site','safe'),
                array('sender_mail', 'length', 'max'=>64),
                array('sender_name', 'length', 'max'=>12),
                array('subject, phone', 'length', 'max'=>255),
                array('mailheader, mailfooter','safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, sender_mail, sender_name, subject, body, phone, files, ip, create_date', 'safe', 'on'=>'search'),
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
			'sender_mail' => 'E-mail',
			'sender_name' => 'ФИО',
			'subject' => 'Subject',
			'body' => 'Сообщение',
            'phone' => 'Телефон',
            'site'=>'Site',
            'mailheader' => 'Mail Header',
            'mailfooter' => 'Mail Footer',
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

		$criteria->compare('sender_mail',$this->sender_mail,true);
        $criteria->compare('sender_name',$this->sender_name,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('ip',ip2long($this->ip),true);

		return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'route'=>Yii::app()->urlManager->createUrl('backend/feedback/feedback/maillist',array('language'=>Yii::app()->language)),
                    'params'=>(isset($_GET['url'])) ? array('url'=>urlencode($_GET['url'])) : array(),
                    'defaultOrder' => 'create_date DESC',
                ),
                'pagination'=>array(
                    'route'=>Yii::app()->urlManager->createUrl('backend/feedback/feedback/maillist',array('language'=>Yii::app()->language)),
                    'params'=>isset($_GET['url']) ? ['url'=>urlencode($_GET['url']),'language'=>Yii::app()->language] : ['language'=>Yii::app()->language],
                    'pageVar'=>'page',
                    'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                ),
            )
        );
	}

    public function onFeedback($event)
    {
        // Непосредственно вызывать событие принято в его описании.
        // Это позволяет использовать данный метод вместо raiseEvent
        // во всём остальном коде.
        $this->raiseEvent('onFeedback', $event);
    }

    protected function beforeDelete()
    {
        if(parent::beforeDelete()){
            $files = unserialize($this->files);
            if(is_array($files)){
                foreach($files as $file){
                    $fileName = $file['name'];
                    $file = file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$fileName) ? Yii::getPathOfAlias('webroot').'/uploads/'.$fileName : null;
                    $thumb = file_exists(Yii::getPathOfAlias('webroot').'/uploads/thumbnail/'.$fileName) ? Yii::getPathOfAlias('webroot').'/uploads/thumbnail/'.$fileName : null;
                    if($file)
                        unlink($file);
                    if($thumb)
                        unlink($thumb);
                }
            }
            return true;
        }

        return false;
    }

    public static function getMaillistCount() {
        $model = self::model()->findAll();
        return count($model);
    }
}
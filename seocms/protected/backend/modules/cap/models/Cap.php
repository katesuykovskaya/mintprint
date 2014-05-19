<?php

/**
 * This is the model class for table "Cap".
 *
 * The followings are the available columns in table 'Cap':
 * @property string $id
 * @property string $img
 * @property integer $show
 * @property integer $move
 */
class Cap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cap the static model class
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
		return 'Cap';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('img', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			array('show, move', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, show', 'safe', 'on'=>'search'),
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
            'translation'=>array(self::HAS_MANY, 'CapTranslate', 't_id', 'index'=>'t_language')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'img' => Yii::t('backend', 'Изображение'),
			'show' => Yii::t('backend', 'Показывать'),
			'move' => 'Move',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('show',$this->show);
		$criteria->compare('move',$this->move);
        $criteria->together = true;
        $criteria->order = 'move ASC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
//            'pagination'=>array(
//                'route'=>Yii::app()->urlManager->createUrl('backend/cap/cap/admin',array('language'=>Yii::app()->language)),
//                'pageVar'=>'page',
//                'params'=>isset($_GET['url']) ? array('url'=>urlencode($_GET['url'])) : array(),
//                'pagesize'=>10,
//            ),
        ));
	}

    protected function afterSave() {
        if($this->isNewRecord) {
            $translate = new CapTranslate;
            $translate->attributes = $_POST['CapTranslate'];
            $translate->t_id = $this->id;
            $translate->t_language = Yii::app()->language;
            $translate->save(false);
        } else {
            $translate = Cap::model()->findByPk($this->id)->translation;
            if(!isset($translate[Yii::app()->language]))
                $translate = new CapTranslate;
            else
                $translate = $translate[Yii::app()->language];
            $translate->attributes = $_POST['CapTranslate'];
            $translate->t_id = $this->id;
            $translate->t_language = Yii::app()->language;
            $translate->save(false);
        }
        parent::afterSave();
    }

    protected function afterDelete() {
        foreach($this->translation as $model) {
            $model->delete();
        }
    }
}
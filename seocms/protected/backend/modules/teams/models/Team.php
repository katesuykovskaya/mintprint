<?php

/**
 * This is the model class for table "Teams".
 *
 * The followings are the available columns in table 'Teams':
 * @property string $id
 * @property string $season
 * @property string $photo
 */
class Team extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Team the static model class
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
		return 'Teams';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, season', 'required'),
            array('id', 'unique', 'message'=>Yii::t('backend', 'Такая команда уже существует!!')),
			array('id', 'length', 'max'=>20),
			array('season', 'length', 'max'=>50),
            array('id', 'match', 'pattern'=>'/^\w-\d+$/', 'message'=>'Название команды должно быть, например U-18'),
            array('photo', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, season', 'safe', 'on'=>'search'),
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
            'players'=>[self::MANY_MANY, 'Player', 'TeamsPlayers(team_id, player_id)', 'order'=>'player_role'],
            'team_player'=>[self::HAS_MANY, 'TeamPlayer', 'team_id']
		);
	}

    protected function afterDelete(){
        foreach($this->team_player as $model)
            $model->delete();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Название',
			'season' => 'Сезон',
			'photo' => 'Фото',
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
		$criteria->compare('season',$this->season,true);
		$criteria->compare('photo',$this->photo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'route'=>Yii::app()->urlManager->createUrl('/backend/teams/teams/admin',array('language'=>Yii::app()->language)),
                'pageVar'=>'page',
                'params'=>isset($_GET['url']) ? array('url'=>urlencode($_GET['url'])) : array(),
                'pagesize'=>10,
            ),
		));
	}
}
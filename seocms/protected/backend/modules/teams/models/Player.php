<?php

/**
 * This is the model class for table "Players".
 *
 * The followings are the available columns in table 'Players':
 * @property integer $id
 * @property string $fio
 * @property string $country
 * @property string $birth_date
 * @property string $player_role
 */
class Player extends CActiveRecord
{
    public  $team_search;
    public $language_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Player the static model class
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
		return 'Players';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' birth_date, player_role', 'required'),
//			array('fio', 'length', 'max'=>255),
//			array('country', 'length', 'max'=>50),
			array('player_role', 'length', 'max'=>26),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fio, country, birth_date, player_role, team_player.team_id, team_search', 'safe', 'on'=>'search'),
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
            'team_player'=>array(self::HAS_ONE, 'TeamPlayer', 'player_id'),
            'teams'=>array(self::MANY_MANY, 'Team','TeamsPlayers(player_id, team_id)'),
            'translation' => array(self::HAS_MANY, 'PlayerTranslate', 't_id','index'=>'t_language'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fio' => 'ФИО',
			'country' => 'Страна',
			'birth_date' => 'День рождения',
			'player_role' => 'Роль',
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
        $criteria->with = array('team_player');
        $criteria->together = true;

		$criteria->compare('id',$this->id);
//		$criteria->compare('fio',$this->fio,true);
//		$criteria->compare('country',$this->country,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('player_role',$this->player_role,false);
//        $criteria->compare('translation.t_language', $this->language_search, true);
//        $criteria->compare('translation.t_id', $this->id, true);
        $criteria->compare('team_player.team_id', $this->team_search, true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'route'=>Yii::app()->urlManager->createUrl('backend/teams/players/admin',array('language'=>Yii::app()->language)),
                'pageVar'=>'page',
                'params'=>isset($_GET['url']) ? array('url'=>urlencode($_GET['url'])) : array(),
                'pagesize'=>10,
            ),
		));
	}

    protected function afterDelete() {
        $this->team_player->delete();
        foreach($this->translation as $model) {
            $model->delete();
        }
        parent::afterDelete();
    }

    protected function afterSave(){
        $languages = Yii::app()->params['languages'];
        if($this->isNewRecord) {
            foreach($languages as $language) {
                $lang = new PlayerTranslate;
                $lang->t_id = $this->id;
                $lang->t_language = $language['langcode'];
//                echo $language['langcode'].'<br/>';
                foreach($lang->translateAttributes as $field) {
                    $label = $field['label'];
                    $lang->$label = $_POST['PlayerTranslate'][$field['label']][$language['langcode']];
//                        isset($_POST['PlayerTranslate'][$field['label']][$language['langcode']]) ?
//                        : null;
                }
                $lang->save(false);
            }
        } else {
            foreach($languages as $language){
                $lang = PlayerTranslate::model()->findByAttributes(
                    array(
                        't_id'=>$this->id,
                        't_language'=>$language['langcode']
                    )
                );
                if($lang === null){
                    $lang = new PlayerTranslate;
                    $lang->t_id = $this->id;
                    $lang->t_lang = $language['langcode'];
                }

//                foreach($this->translateAttributes as $field) {
//                    if($field['label'] ==='t_translit'){
//                        $this->updateMenuUrl($lang,$_POST['t_title'],$language['langcode']);
//                        $lang->t_translit = isset($_POST['t_title'])
//                            ? Translit::cyrillicToLatin ($_POST['t_title'][$language['langcode']])
//                            : null;
//                    } else {
//                        $lang->$field['label'] = isset($_POST[$field['label']][$language['langcode']])
//                            ? $_POST[$field['label']][$language['langcode']]
//                            : null;
//                    }
//                }
                $lang->t_fio = $_POST['PlayerTranslate']['t_fio'][$language['langcode']];
                $lang->t_country = $_POST['PlayerTranslate']['t_country'][$language['langcode']];
                $lang->save(false);
            }
        }
        parent::afterSave();
    }

    public function behaviors() {
        return array(
            'Multilanguage'=>array(
                'class'=>'application.backend.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                    't_fio'=>array(
                        'label'=>'t_fio',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                    't_country'=>array(
                        'label'=>'t_country',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                        ),
                    ),
                ),
            ),
        );
    }

    public static function getLangDropdown()
    {
        $arr = array();
        foreach(Yii::app()->params['languages'] as $language)
        {
            $arr[$language['langcode']] = $language['lang'];
        }
        return $arr;
    }

//    public function behaviors()
//    {
//        return array(
//            'activerecord-relation'=>array(
//                'class'=>'application.backend.extensions.yiiext.behaviors.activerecord-relation.EActiveRecordRelationBehavior',
//            ));
//    }
}
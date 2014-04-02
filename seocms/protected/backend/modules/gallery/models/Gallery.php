<?php

/**
 * This is the model class for table "Gallery".
 *
 * The followings are the available columns in table 'Gallery':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $type
 */
class Gallery extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gallery the static model class
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
		return 'Gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'required'),
//			array('lft, rgt, level', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lft, rgt, level, type, root', 'safe', 'on'=>'search'),
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
            'translation'=>[self::HAS_MANY,'GalleryTranslate','t_id','index'=>'t_language'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'type' => 'Type',
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
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getNodeType()
    {
        $arr = [
            'image'=>'<i class="icon-picture icon-2x"></i>',
            'video'=>'<i class="icon-film icon-2x"></i>',
            'audio'=>'<i class="icon-music icon-2x"></i>',
            'embed'=>'<i class="icon-film icon-2x"></i>',
            'file'=>'<i class="icon-file icon-2x"></i>',
        ];

        return $arr[$this->translation[Yii::app()->language]->t_fileType];
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
            ),
            'Multilanguage'=>array(
                'class'=>'application.backend.modules.gallery.components.Multilanguage',
                'languages'=>Yii::app()->params['languages'],
                'translateAttributes'=>array(
                    't_title'=>array(
                        'label'=>'t_title',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_file'=>array(
                        'label'=>'t_file',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_fileType'=>array(
                        'label'=>'t_fileType',
                        'fieldType'=>'dropDownList',
                        'value'=>['1'=>'image','2'=>'video','3'=>'audio','4'=>'embed'],
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge'
                        ),
                    ),
                    't_meta'=>array(
                        'label'=>'t_meta',
                        'fieldType'=>'dropDownList',
                        'value'=>['imgalt'=>'imgalt','imgtitle'=>'imgtitle'],
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge imgmeta'
                        ),
                    ),
                    't_createdate'=>array(
                        'label'=>'t_createdate',
                        'fieldType'=>'textField',
                        'value'=>'',
                        'htmlOptions'=>array(
                            'class'=>'input-xxlarge date'
                        ),
                    ),
                ),
            ),
        );
    }

    public function afterSave()
    {
        if($this->isNewRecord) {
            $languages = Yii::app()->params['languages'];

            foreach($languages as $language) {
                $lang = new GalleryTranslate;
                $lang->t_id = $this->id;
                $lang->t_language = $language['langcode'];

                foreach($this->translateAttributes as $field) {
                    if ($field['label'] === 't_meta')
//                        $lang->t_meta = (isset($_POST['GalleryTranslate[t_meta]'])) ? serialize($_POST['GalleryTranslate']['t_meta']) : null;
                       continue;
                    else {
                        $lang->$field['label'] = isset($_POST['GalleryTranslate'][$field['label']][$language['langcode']])
                            ? $_POST['GalleryTranslate'][$field['label']][$language['langcode']]
                            : null;
                    }
                }
                $lang->t_createdate = (!isset($_POST['GalleryTranslate']['t_createdate'][$language['langcode']]) || $_POST['GalleryTranslate']['t_createdate'][$language['langcode']] === '') ? null : $_POST['GalleryTranslate']['t_createdate'][$language['langcode']];
                $lang->save(false);
            }
        } else {
            $languages = Yii::app()->params['languages'];

            foreach($languages as $language){
                $lang = GalleryTranslate::model()->findByAttributes(
                    array(
                        't_id'=>$this->id,
                        't_language'=>$language['langcode']
                    )
                );
                if($lang === null){
                    $lang = new GalleryTranslate;
                    $lang->t_id = $this->id;
                    $lang->t_language = $language['langcode'];
                }

                foreach($this->translateAttributes as $field) {
                    if($field['label'] === 't_meta'){
//                        $metaArray = [];
//                        foreach($this->translateAttributes['t_meta']['value'] as $key=>$attribute){
//                            $metaArray[$attribute] = $_POST['GalleryTranslate'][$attribute][$language['langcode']];
                            continue;
//                        }
//                        $lang->t_meta = serialize($metaArray);
                    } else {
                        $lang->$field['label'] = isset($_POST['NewsTranslate'][$field['label']][$language['langcode']])
                            ? $_POST['NewsTranslate'][$field['label']][$language['langcode']]
                            : null;
                    }
                }

                $lang->t_createdate = ($_POST['GalleryTranslate']['t_createdate'][$language['langcode']] === '0000-00-00 00:00:00') ? null : $_POST['GalleryTranslate']['t_createdate'][$language['langcode']];
                $lang->save(false);
            }
        }

        parent::afterSave();
    }

    public function GetVideosOfEvent($id) {
        $model = Gallery::model()->findByPk($id);
        $model = $model->children()->with(array(
                'translation'=>array(
                    'order'=>'t_createdate DESC',
//                'on'=>'t_language=".'.Yii::app()->language.'"',
//                'condition'=>'t_language=".'.Yii::app()->language.'"',
                    'index'=>'t_language')
            )
        )->findAll();
//        die(CVarDumper::dump($model, 8, true));
        $blocks = [];
        foreach($model as $key=>$val) {
            $tmb = $val->translation[Yii::app()->language]->t_file;
            $videoId = pathinfo(explode('video-', $tmb)[1], PATHINFO_FILENAME);
            $embed = CHtml::openTag('iframe', array(
                    'width'=>'640',
                    'height'=>'360',
                    'class'=>'iframe',
                    'src'=>'//www.youtube.com/embed/'.$videoId.'?feature=player_detailpage&autoplay=0',
                    'frameborder'=>0,
                    'allowfullscreen'=>'allowfullscreen'
                )).CHtml::closeTag('iframe');
            $name = isset($val->translation[Yii::app()->language]->t_title) ? $val->translation[Yii::app()->language]->t_title : '';
            $videoName = CHtml::openTag('p', ['class'=>'video-name']).$name.CHtml::closeTag('p');
            $blocks[] = $embed.$videoName;
        }
        return implode('', $blocks);
    }

    public function GetPhotosForMain() {
        $photos = GalleryTranslate::model()->with(array('gallery'=>array(
            'condition'=>'root=22 AND level=3',
            'order'=>'lft')
                )
            )->findAllByAttributes(array(
                't_language'=>Yii::app()->language
            ), array(
                'index'=>'t_id',
            ));

        $events = GalleryTranslate::model()->with(array('gallery'=>array(
                'condition'=>'root=22 AND level=2',
                'order'=>'lft DESC')
            )
        ) ->findAllByAttributes(array(
                't_language'=>Yii::app()->language
            ), array(
                'index'=>'t_id',
            ));

        $arr = [];

        foreach($events as $k=>$v) {
            $arr[$k]['event'] = $v;
        }

        foreach($photos as $k=>$v) {
            $pattern = '/\/galleries\/(\d+)\/.*/';
            $out = array();
            preg_match_all($pattern, $v->t_file, $out);
            $parent = $out[1][0];
            $arr[$parent]['photos'][] = $v;
//            CVarDumper::dump($out, 6, true);
        }

//        foreach($arr as $k=>$v) {
//            echo $v['event']->t_title.' - '.$v['event']->t_createdate.'<br>';
//            foreach($v['photos'] as $k1=>$v1) {
//                echo '----'.$v1->t_file.' - '.$v1->t_createdate.'<br>';
//            }
//            echo '<hr>';
//        }
//        die();
        return $arr;
    }

    public function GetVideosForMain() {
        $model = GalleryTranslate::model()->with(array('gallery'=>array(
            'condition'=>'root=28 AND level=3'
        )))->findAllByAttributes(
                array(
                    't_fileType'=>4,
                    't_language'=>Yii::app()->language,
                ), array(
                'order'=>'t_createdate DESC',
                'limit'=>6
            ));
        return $model;
    }
}
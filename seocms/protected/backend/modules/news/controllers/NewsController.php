<?php

class NewsController extends Controller
{
	public $layout='//layouts/main';
    public $defaultAction = 'Admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
            'rights'
//            array('auth.filters.AuthFilter'),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new News;
        $newsTranslate = new NewsTranslate;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']) || isset($_POST['NewsTranslate']))
		{
			$model->attributes=$_POST['News'];
            if($model->save()){
                $this->redirect($this->createUrl('/backend/news/news/admin',['language'=>Yii::app()->language]));
            } else {
                echo (CVarDumper::dump($model->errors, 2, 1));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'newsTranslate'=>$newsTranslate
		));
	}

    /**
     * @param $model
     * @param bool $param  - if true - create new Model instance, else - load model from DB
     * @return array - array with data to store in Yii booster's each tab content
     */
    public function tabsArray($model,$param = true)
    {
        $tabsArray = array();
        foreach(Yii::app()->params['languages'] as $language)
        {
            if($param) {
                if(Yii::app()->language == $language['langcode']) {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $model,
                                $language['langcode']
                            ),
                        'active'=>true
                    );
                } else {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $model,
                                $language['langcode']
                            )
                    );
                }
            } else {
                if(Yii::app()->language == $language['langcode']) {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $this->loadMultilangModel($model->id,$language['langcode']),
                                $language['langcode'],$param=false
                            ),
                        'active'=>true
                    );
                } else {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                            $this->getTabContent(
                                $this->loadMultilangModel($model->id,$language['langcode']),
                                $language['langcode'],
                                $param=false)
                    );
                }
            }
        }
        return $tabsArray;
    }

    public function getTabContent($model,$lang,$param = true)
    {
        $fieldsArray = $model->translateAttributes;
        $content = '';
        if($param) {
            foreach($fieldsArray as $key=>$field) {

                if($field['label'] !== 't_imgmeta')
                    $label = CHtml::activeLabel($model, Yii::t('backend',$field['label']));
                else
                    $label = '<h5 class="page-header">'.Yii::t('backend',$field['label']).':</h5>';

                if($field['fieldType'] !== 'dropDownList'){
                    if($field['fieldType'] == 'datePicker') {
                        ob_start();
                        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name'=>'NewsTranslate['.$field['label'].']['.$lang.']',
                            'flat'=>true,//remove to hide the datepicker,
                            'value'=>isset($field['value']) ? $field['value'] : date('d.m.Y'),
                            'options'=>array(
                                'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                'dateFormat'=>'yy-mm-dd',
                            ),
                            'htmlOptions'=>array(
                                'style'=>''
                            ),
                        ));
                        $textField = ob_get_clean();
                    } else {
                        $formField = 'active'.ucfirst($field['fieldType']);
                        $textField = CHtml::$formField($model, $field['label'].'['.$lang.']',$field['htmlOptions']);
                    }
                } else {
                    if($field['label'] !== 't_imgmeta'){
                        $formField = 'active'.ucfirst($field['fieldType']);
                        $textField = CHtml::dropDownList('NewsTranslate['.$field["label"].']['.$lang.']','',$field['value'],$field['htmlOptions']).'<hr />';
                    } else {
                        $textField = '';
                        foreach($field['value'] as $key=>$value)
                            $textField .= CHtml::label(Yii::t('backend',$value),'NewsTranslate_imgmeta_'.$value.'_'.$lang).'<br />'.CHtml::textField('NewsTranslate[imgmeta]['.$value.']['.$lang.']', '',$field['htmlOptions']);
                    }
                }

                $content .= $label.$textField;
            }
        } else {
            foreach($fieldsArray as $key=>$field) {
                /* $model->translation can be NULL if the new project language was added and no
                 * page translation instance was created, it will be created after page save automatically,
                 * but not during adding new language support
                 * */
                if($model->translation === null)
                    $model->translation = new NewsTranslate;

                if($field['label'] !== 't_imgmeta')
                    $label = CHtml::activeLabel($model, Yii::t('backend',$field['label']));
                else
                    $label = '<h5 class="page-header">'.Yii::t('backend',$field['label']).':</h5>';

                $formField = 'active'.ucfirst($field['fieldType']);
                $htmlOptions = $field['htmlOptions'];
                $htmlOptions['name'] = 'NewsTranslate['.$field['label'].']['.$lang.']';

                if($field['fieldType'] !== 'dropDownList') {
                    if($field['fieldType'] == 'datePicker') {
                        ob_start();
                        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name'=>'NewsTranslate['.$field['label'].']['.$lang.']',
                            'flat'=>true,//remove to hide the datepicker
                            'value'=>date("d.m.Y", strtotime($model->translation[$lang]->{$field['label']})),
                            'options'=>array(
                                'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                            ),
                        ));
                        $textField = ob_get_clean();
                    } else {
                        $textField = CHtml::$formField($model->translation[$lang], $field['label'],$htmlOptions).'<hr />';
                    }
                } else {
                    if($field['label'] !== 't_imgmeta'){
                        $textField = CHtml::dropDownList('NewsTranslate['.$field["label"].']['.$lang.']',$model->translation[$lang][$field['label']],$field['value'],$htmlOptions).'<hr />';
                    } else {
                        $imgmeta = unserialize($model->translation[$lang]['t_imgmeta']);
                        $textField = '';
                        foreach($field['value'] as $key=>$value){
                            $textField .= CHtml::label(Yii::t('backend',$value),'NewsTranslate_imgmeta_'.$value.'_'.$lang).'<br />'.
                                CHtml::textField('NewsTranslate[imgmeta]['.$value.']['.$lang.']',$imgmeta[$value][$lang],$field['htmlOptions']);
                        }
                    }
                }
                $content .= $label.$textField;
            }
        }

        return $content;
    }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewsTranslate']))
		{
            if(isset($_POST['News'])){
                $model->attributes=$_POST['News'];
            }
//            $model->img = isset($_POST['News']['img']) ? CUploadedFile::getInstance($model,'img') : $model->img;
            if($model->save()){
//                if(isset($_POST['News']['img'])){
//                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR;
//                    if(is_dir($imgDir)){
//                        $model->img->saveAs($imgDir.$model->img->name);
//                    } else {
//                        mkdir($imgDir,0777,true);
//                        $model->img->saveAs($imgDir.$model->img->name);
//                    }
//                }

                $this->redirect($this->createUrl('/backend/news/news/admin',['language'=>Yii::app()->language]));
            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionUrlGenerate()
    {
        if(Yii::app()->request->isAjaxRequest){
            $title = Yii::app()->request->getParam('title');
            if($title){
                $url = Translit::cyrillicToLatin($title);
            }
            echo $url;
        }
    }

    public function actionDelImage()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_POST['id'])) ? (int)$_POST['id'] : null;
            $name = (isset($_POST['name'])) ? $_POST['name'] : null;
            $file = Yii::getPathOfAlias('webroot').$name;
            if($id){
                $sql = "update News set img=NULL where id='".$id."'";
                $command = Yii::app()->db->createCommand($sql)->execute();
                if($command){
                    if(is_file($file)){
                        unlink($file);
                    }
                    echo CJSON::encode(array('success'=>true));
                } else {
                    echo CJSON::encode(array('success'=>false));
                }
            }
        }
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('News');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return News the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


    public function loadMultilangModel($id,$lang)
    {
        $model = News::model()
            ->with(array(
                'translation'=>array(
                    'joinType'=>'LEFT JOIN',
                    'on'=>'translation.t_language=:lang',
                    'params'=>array(':lang'=>$lang),
                )))->findByAttributes(array('id'=>$id));
        return $model;
    }

	/**
	 * Performs the AJAX validation.
	 * @param News $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

//class PagesController extends RightsBaseController
class PagesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            array('auth.filters.AuthFilter - login'),
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//                    'rights',
		);
	}

    public function actions()
    {
        return array(
            'editor'=>'application.backend.components.EditorAction'
        );
    }

//	/**
//	 * Displays a particular model.
//	 * @param integer $id the ID of the model to be displayed
//	 */
//	public function actionView($id)
//	{
//		$this->render('view',array(
//			'model'=>$this->loadModel($id),
//		));
//	}
        
        public function actionPageTree()
        {
            $baseUrl=Yii::app()->request->baseUrl;
            $this->render('pageTree',array(
                'baseUrl'=>$baseUrl,
            ));
        }
        
       public function actionFetchTree(){
           StaticPages::printULTree();
        }

    /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                
        $translate = new PagesTranslate;
        $count = Yii::app()->db->createCommand("select count(page_id) from static_pages")->queryScalar();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
        if(isset($_POST['parent']))
        {
            $parent = intval($_POST['parent']);

            if($parent !== 0) {
                $model = new StaticPages;
                $model->img = CUploadedFile::getInstance($translate,'img');
                $root = StaticPages::model()->findByPk($parent);
                $model->appendTo($root);
                if($model->img){
                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->page_id.DIRECTORY_SEPARATOR;
                    if(is_dir($imgDir)){
                        $model->img->saveAs($imgDir.$model->img->name);
                    } else {
                        mkdir($imgDir,0777,true);
                        $model->img->saveAs($imgDir.$model->img->name);
                    }
                }

            } elseif($parent === 0 && (int)$count === 0){
                $model = new StaticPages;
                $model->saveNode();
            } else {
                throw new CHttpException('403',Yii::t('backend','Создавать страницу без родителя запрещено!'));
            }
        }
		$this->render('create',array(
            'translate'=>$translate,
            'count'=>$count
		));
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
//		 $this->performAjaxValidation($model);

		if(isset($_POST['parent']))
		{
            $image = (!empty($_FILES['StaticPages'])) ? $_FILES['StaticPages']['name']['img'] : null;
            $model->img = $image ? CUploadedFile::getInstance($model,'img') : $model->img;
            if($model->saveNode()){
                if($model->img && $image){
                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->page_id.DIRECTORY_SEPARATOR;
                    if(is_dir($imgDir)){
                        $model->img->saveAs($imgDir.$model->img->name);
                    } else {
                        mkdir($imgDir,0777,true);
                        $model->img->saveAs($imgDir.$model->img->name);
                    }
                }
                $this->redirect(array('/pages/pages/grid'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionDelImage()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_POST['id'])) ? (int)$_POST['id'] : null;
            $name = (isset($_POST['name'])) ? $_POST['name'] : null;
            $file = Yii::getPathOfAlias('webroot').$name;
            if($id){
                $sql = "update static_pages set img=NULL where page_id='".$id."'";
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
     * @throws Exception
     */
	public function actionDelete($id)
	{
        $staticPage = StaticPages::model()->findByPk($id);
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $sql = "delete from translate_pages where page_id='".$id."'";
            $pageTranslate = Yii::app()->db->createCommand($sql)->execute();
            if($staticPage->deleteNode() && $pageTranslate){
                $transaction->commit();
            } else {
                $transaction->rollback();
            }

        } catch(Exception $e) {
            $transaction->rollback();
            throw $e;
        }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

//	/**
//	 * Lists all models.
//	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('StaticPages');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

//	/**
//	 * Manages all models.
//	 */
//	public function actionAdmin()
//	{
//		$model=new StaticPages('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['StaticPages']))
//			$model->attributes=$_GET['StaticPages'];
//
//		$this->render('admin',array(
//			'model'=>$model,
//		));
//	}

    public function actionGrid()
	{
        $this->layout = '//layouts/main';
		$model=new PagesTranslate('search');
		$model->unsetAttributes();  // clear any default values
                $model->t_lang = Yii::app()->language; // setting the default language
		$model->published = 1;
                if(isset($_GET['PagesTranslate'])) {
			$model->attributes=$_GET['PagesTranslate'];
                }
		$this->render('grid',array(
			'model'=>$model,
		));
	}
        
    public function actionGridSave()
    {
        if (isset($_POST['sortOrder'])) {
        //обработчик в jquery.sortable.gridview.js
            $el = isset($_POST['selected']) ? $_POST['selected'] : false;
            $filters = isset($_POST['filters']) ? $_POST['filters'] : false;
            $post = Yii::app()->request;
        if (!$el) {
            $data = array('success' => 'not ok',);
        } else {
                
            $curPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : null;
            $newOrder = isset($_POST['newOrder']) ? $_POST['newOrder'] : null;
            $pageSize = PagesTranslate::model()->search()->pagination->pagesize;
            $root = StaticPages::model()->findByPk($el);

        // обработка постранички (нельзя делать при постраничке moveAsFirst)
            if($curPage == 1) {

                $children = $root->children()->findAll();

                    $id = array_shift($newOrder);
                    $model = PagesTranslate::model()->findByPk($id);
                    $first = StaticPages::model()->findByPk($model->page_id);
                    $first->moveAsFirst($root);

                    $this->moveNodes($newOrder, $first);

                    $data = array('success' => 'ok',
                    'selected' => $el,
                    'children' => $children,
                    'newOrder' => $newOrder,
                    'currentPage' => $curPage,
                    'pageSize' => $pageSize,
                    'post' => $post,
                    'filters'=>$filters,
                );
            } else {
                $childrenCriteria = new CDbCriteria;
                $childrenCriteria->limit = $curPage*$pageSize;
                $childrenCriteria->offset = $pageSize;
                $children = $root->children()->findAll($childrenCriteria);
                $childrenNum = count($children);
                $arrNum = count($newOrder);
                $countErr = $arrNum != $childrenNum ? true : false;

                if (!$countErr) {
                        $id = array_shift($newOrder);
                        $model = PagesTranslate::model()->findByPk($id);
                        $first = StaticPages::model()->findByPk($model->page_id);
                        $limit = (($curPage-1)*$pageSize)-1;

                        $prevCriteria = new CDbCriteria;
                        $prevCriteria->condition = 'lft>'.$root->lft.' AND rgt<'.$root->rgt.' AND level='.$first->level;
                        $prevCriteria->limit = $limit;
                        $prevCriteria->offset = $limit;
                        $prevCriteria->order = 'lft';
                        $prev = StaticPages::model()->find($prevCriteria);

                        $first->moveAfter($prev);
                        $this->moveNodes($newOrder, $first);
                }

                $data = array('success' => 'ok',
                    'selected' => $el,
                    'children' => $children,
                    'countError' => $countErr,
                    'newOrder' => $newOrder,
                    'currentPage' => $curPage,
                    'pageSize' => $pageSize,
                    'prev' => $prev,
                    'limit' => $limit,
                    'post' => $post,
                    'filters'=>$filters,
                );
            }
        }

        echo CJSON::encode($data);
        Yii::app()->end();
        }
    }
        
    public function moveNodes($arr=array(),$parent)
    {
        if(!empty($arr)){
            $id = array_shift($arr);
        $model = PagesTranslate::model()->findByPk($id);
        $node = StaticPages::model()->findByPk($model->page_id);
            $node->moveAfter($parent);
        $this->moveNodes($arr,$node);
        }else{
            return;
        }
    }

        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StaticPages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StaticPages::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
                                                        $this->loadMultilangModel($model->page_id,$language['langcode']),
                                                        $language['langcode'],$param=false
                                                        ),
                                            'active'=>true
                                            );
                    } else {
                        $tabsArray[] = array(
                                            'label'=>$language['lang'],
                                            'content'=>
                                                $this->getTabContent(
                                                        $this->loadMultilangModel($model->page_id,$language['langcode']),
                                                        $language['langcode'],
                                                        $param=false)
                                            );
                    }
                }
            }
            return $tabsArray;
        }
        
//        public function tinyToTabs($model,$field,$lang)
//        {
//            $name = $model->scenario == 'insert' ? 'PagesTranslate['.$field.']['.$lang.']' : $field.'['.$lang.']' ;
////                 $editor = $this->widget('ext.tinymce.TinyMce', array(
////                        'model' => $model,
////                        'attribute' => $field,
////                        'language'=>$lang,
////                        // Optional config
////                        'compressorRoute' => 'tinyMce/compressor',
////                        //'spellcheckerUrl' => array('tinyMce/spellchecker'),
////                        // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
////              //          'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
////                        'fileManager' => array(
////                            'class' => 'ext.elFinder.TinyMceElFinder',
////                            //route to class with action connector (class or controller)
////                            'connectorRoute'=>'elfinder/connector',
////                        ),
////                        'htmlOptions' => array(
////                           'name'=>$name,
////                           // 'rows' => 6,
////                           // 'cols' => 60,
////                            'width'=>'auto',
////                        ),
////                    ),true);
//
//            $editor = $this->widget('application.backend.extensions.tinymce.TinyMceWidget',
//                array(
//                    'model' => $model,
//                    'attribute' => 'textarea',
//                    'language'=>$lang,
//                ),
//                true
//            );
//
//            return $editor;
//        }
        
        public function getTabContent($model,$lang,$param = true)
        {
//            $fieldsArray = Yii::app()->params['translateAttrs'];
            $fieldsArray = $model->translateAttributes;
            $content = '';

            if($param) {
                foreach($fieldsArray as $key=>$field) {
                    $label = CHtml::activeLabel($model, $field['label']);
//                    if($field['fieldType']=='textArea')
//                        $textField = $this->tinyToTabs($model, $field['label'], $lang);
//                    else {
                        $formField = 'active'.ucfirst($field['fieldType']);
                        $textField = CHtml::$formField($model, $field['label'].'['.$lang.']',$field['htmlOptions']);
//                    }

                    $content .= $label.$textField;
                }
            } else {
                    foreach($fieldsArray as $key=>$field) {
                        /* $model->translation can be NULL if the new project language was added and no
                         * page translation instance was created, it will be created after page save automatically,
                         * but not during adding new language support
                         * */
                        echo CVarDumper::dump($model, 7, true);
                        if($model->translation === null)
                            $model->translation = new PagesTranslate;
                        $label = CHtml::activeLabel($model->translation, $field['label']);

//                        if($field=='t_content') {
//                            $textField = $this->tinyToTabs($model->translation, $field, $lang);
//                        } else {
                            $formField = 'active'.ucfirst($field['fieldType']);
                            $htmlOptions = $field['htmlOptions'];
                            $htmlOptions['name'] = $field['label'].'['.$lang.']';
                            $textField = CHtml::$formField($model->translation, $field['label'],$htmlOptions).'<hr />';
//                        }

                        $content .= $label.$textField;
                    }
            }

            return $content;
        }

    public function loadMultilangModel($id,$lang)
    {
        $model = StaticPages::model()
            ->with(array(
                'translation'=>array(
                    'joinType'=>'LEFT JOIN',
                    'on'=>'translation.t_lang=:lang',
                    'params'=>array(':lang'=>$lang),
            )))->findByAttributes(array('page_id'=>$id));
        return $model;
    }

        /**
	 * Performs the AJAX validation.
	 * @param StaticPages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='static-pages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}

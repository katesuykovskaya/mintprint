<?php

class GalleryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
//    public $defaultAction = 'Admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return [array('auth.filters.AuthFilter')];
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $root = Gallery::model()->findByPk($id);
        $categories = $root->with(['translation'])->children()->findAll(['order'=>'translation.t_createdate DESC']);
		$this->render('view',[
                'model'=>$this->loadModel($id),
                'categories'=>$categories
                ]
        );
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
//	public function actionCreate()
//	{
//		$model=new Gallery;
//        $translation = new GalleryTranslate;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Gallery']))
//		{
//			$model->attributes=$_POST['Gallery'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//		}
//
//		$this->render('create',array(
//			'model'=>$model,
//            'translation'=>$translation,
//		));
//	}

    public function actionGalleryCreate()
    {
        $model = new Gallery;

        if(isset($_POST['Gallery'])){
            $model->attributes = $_POST['Gallery'];
            if($model->saveNode()){
                $this->redirect($this->createUrl('/backend/gallery/gallery/index',['language'=>Yii::app()->language]));
            }
        }

        $this->render('galleryForm',['model'=>$model]);
    }

    public function actionCreateCategory()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = Yii::app()->request->getParam('root',null);

            if($id){
                $root = Gallery::model()->findByPk($id);
                $category = new Gallery;
                $category->type = 'category';
                foreach(Yii::app()->params['languages'] as $key=>$language){
                    $_POST['GalleryTranslate']['t_fileType'][$language['langcode']] = 5;
                }
                if($category->appendTo($root)) {
                    Yii::app()->user->setFlash('category-success',Yii::t('backend','Событие успешно добавлено'));
                } else {
                    Yii::app()->user->setFlash('category-error',Yii::t('backend','Событие не было добавлено'));
                }

            }
        }
    }

    public function actionEventEdit()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
            if($id){
                $model = Gallery::model()->findByPk($id);
                $editForm = [];
                foreach(Yii::app()->params['languages'] as $key=>$language){
                    $editForm[$language['langcode']]['t_title'] = $model->translation[$language['langcode']]->t_title;
                }
                echo CJSON::encode($editForm);
            }
        }
    }

    public function actionUpdateEvent()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
            if($id){
                $ru = GalleryTranslate::model()->findByAttributes(['t_id'=>$id,'t_language'=>'ru']);
                $ru->t_title = $_POST['GalleryTranslate']['t_title']['ru'];
                $en = GalleryTranslate::model()->findByAttributes(['t_id'=>$id,'t_language'=>'en']);
                $en->t_title = $_POST['GalleryTranslate']['t_title']['en'];
                if($ru->save(false) && $en->save(false)){
                    Yii::app()->user->setFlash('update-success',Yii::t('backend','Данные успешно обновлены'));
                } else {
                    Yii::app()->user->setFlash('update-error',Yii::t('backend','Данные не были обновлены'));
                }
            }
        }
    }

    public function actionInit()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            Yii::import('application.backend.modules.gallery.assets.server.php.UploadHandler');
            $upload_handler = new UploadHandler(true);
            Yii::app()->end();
        }
    }

    public function actionShow()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            Yii::import('application.backend.modules.gallery.assets.server.php.FileHandler');
            $file_handler = new FileHandler(true);
            Yii::app()->end();
        }
    }

    public function actionSaveFiles()
    {
        if(Yii::app()->request->isAjaxRequest){
            $path = (isset($_POST['url'])) ? Yii::getPathOfAlias('webroot').$_POST['url'] : null;
            $nodeId = (isset($_POST['nodeId'])) ? (int)($_POST['nodeId']) : null;

            if(is_dir($path) && $nodeId){
                $newPath = Yii::getPathOfAlias('webroot').'/galleries/'.$nodeId.'/';
                $webPath = '/galleries/'.$nodeId.'/';
                if(!is_dir($newPath)){
                    mkdir($newPath,0777);
               }
                $parent = Gallery::model()->findByPk($nodeId);
                $filesArray = scandir($path);
                foreach($filesArray as $key=>$file){
                    if($file[0] !== '.'){
                        $filePath = $path.$file;
                        if(!is_dir($filePath)){
                            rename($filePath,$newPath.$file);

                            foreach(Yii::app()->params['languages'] as $key=>$language){
                                $_POST['GalleryTranslate']['t_title'][$language['langcode']] = $file;
                                $_POST['GalleryTranslate']['t_file'][$language['langcode']] = $webPath.$file;
                            }

                            $node = new Gallery;
                            $node->type = 3;
                            $node->appendTo($parent);
                        } else {
                            if(!is_dir($newPath.$file))
                                mkdir($newPath.$file,0777);

                            $thumbsArray = scandir($filePath);
                            foreach($thumbsArray as $key => $thumb)
                                if($thumb[0] !== '.'){
                                        rename($filePath.'/'.$thumb,$newPath.'thumbnail/'.$thumb);
                                }
                        }
                    }
                }
            }
        }
    }

    public function actionSubmitVideo()
    {
        if(Yii::app()->request->isAjaxRequest){
            $embedCode = (isset($_POST['embedCode'])) ? $_POST['embedCode'] : null;
            $videoId = (isset($_POST['videoId'])) ? $_POST['videoId'] : null;
            $parent = (isset($_POST['parent'])) ? (int)$_POST['parent'] : null;
            $videoTitle = (isset($_POST['title'])) ? $_POST['title'] : null;

            if($embedCode && $videoId){
                $parentNode = Gallery::model()->findByPk($parent);
                $newNode = new Gallery;
                $newNode->type = 3;
                if(!is_dir(Yii::getPathOfAlias('webroot')."/galleries/".$parentNode->id."/")){
                    @mkdir(Yii::getPathOfAlias('webroot')."/galleries/".$parentNode->id."/",0777);
                    @mkdir(Yii::getPathOfAlias('webroot')."/galleries/".$parentNode->id."/thumbnail/",0777);
                }
                $image = file_put_contents (Yii::getPathOfAlias('webroot')."/galleries/".$parentNode->id."/video-".$videoId.".jpg",file_get_contents("http://img.youtube.com/vi/".$videoId."/0.jpg"));
                $thumb = file_put_contents (Yii::getPathOfAlias('webroot')."/galleries/".$parentNode->id."/thumbnail/video-".$videoId.".jpg",file_get_contents("http://img.youtube.com/vi/".$videoId."/1.jpg"));
                $_POST['GalleryTranslate']['t_title'][Yii::app()->language] = $videoTitle;
                $_POST['GalleryTranslate']['t_fileType']['ru'] = 4;
                $_POST['GalleryTranslate']['t_fileType']['en'] = 4;
                $_POST['GalleryTranslate']['t_file']['ru'] = "/galleries/".$parentNode->id."/video-".$videoId.".jpg";
                $_POST['GalleryTranslate']['t_file']['en'] = "/galleries/".$parentNode->id."/video-".$videoId.".jpg";
                if($newNode->appendTo($parentNode)){
                    Yii::app()->user->setFlash('video-success',Yii::t('backend','Видео добавлено'));
                } else {
                    Yii::app()->user->setFlash('video-error',Yii::t('backend','Видео не было добавлено'));
                }
            }
        }
    }

    public function actionClearTmp()
    {
        if(Yii::app()->request->isAjaxRequest){
            $url = isset($_POST['tmp']) ? $_POST['tmp'] : null;
            if($url){
                $this->delete_files($url);
            }
        }
    }

    /**
     * php delete function that deals with directories recursively
     * @param $target - directory path to work with
     * @return bool
     */
    public function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file )
            {
                $this->delete_files( $file );
            }
            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

//    public function actionHide()
//    {
//        if(Yii::app()->request->isAjaxRequest){
//            $visible = isset($_POST['hidden']) ? (int)$_POST['hidden'] : null;
//            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
//            if(is_int($visible) && is_int($id)){
//                $command = Yii::app()->db->createCommand();
//                $command->update('Attachments',array('hidden'=>($visible === 1) ? 0 : 1),'attachment_id=:id',array(':id'=>$id));
//            }
//
//        }
//    }

    public function actionSort()
    {
        $previous = (isset($_POST['previous'])) ? (int)$_POST['previous'] : null;
        $current = (isset($_POST['current'])) ? (int)$_POST['current'] : null;
        $next = (isset($_POST['next'])) ? (int)$_POST['next'] : null;
        $root = (isset($_POST['root'])) ? (int)$_POST['root'] : null;
        if($current){
            $currentNode = Gallery::model()->findByPk($current);
            $root = Gallery::model()->findByPk($root);

            if($previous){
                $previousNode = Gallery::model()->findByPk($previous);
                $currentNode->moveAfter($previousNode);
            } elseif (!$next){
                $currentNode->moveAsLast($root);
            } else {
                $currentNode->moveAsFirst($root);
            }
        }

    }

    public function actionRemoveNode()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_POST['id'])) ? (int)$_POST['id'] : null;
            $role = (isset($_POST['role'])) ? $_POST['role'] : null;

            if($id){
                $node = Gallery::model()->findByPk($id);
                $parent = $node->parent()->find();
                $filepath = $node->translation[Yii::app()->language]->t_file;
                $countArr = explode('/',$filepath);
                $count = count($countArr);
                $fileName = $countArr[$count-1];
                if($role !== 'category')
                    $thumbPath = Yii::getPathOfAlias('webroot').'/galleries/'.$parent->id.'/thumbnail/'.$fileName;
                else
                    $thumbPath = Yii::getPathOfAlias('webroot').'/galleries/'.$node->id.'/thumbnail/'.$fileName;
                if($node->deleteNode()){
                    @unlink(Yii::getPathOfAlias('webroot').$filepath);
                    @unlink(Yii::getPathOfAlias('webroot').$thumbPath);
                    Yii::app()->user->setFlash('remove-success',Yii::t('backend','Удалено'));
                } else {
                    Yii::app()->user->setFlash('remove-error',Yii::t('backend','Произошла ошибка!'));
                }
            }
        }
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
//	public function actionUpdate($id)
//	{
//		$model=$this->loadModel($id);
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Gallery']))
//		{
//			$model->attributes=$_POST['Gallery'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//		}
//
//		$this->render('update',array(
//			'model'=>$model,
//		));
//	}

    public function actionImageEdit($id)
    {
        $model = $this->loadModel($id);
        $translation = GalleryTranslate::model()->findByAttributes(['t_id'=>$id,'t_language'=>Yii::app()->language]);
        $parent = $model->parent()->find();

        if(isset($_POST['GalleryTranslate'])){
            $metaArray = [];
                foreach($model->translateAttributes['t_meta']['value'] as $key=>$attribute){
                    $metaArray[$attribute] = $_POST['GalleryTranslate'][$attribute][Yii::app()->language];
                }
            $translation->t_meta = serialize($metaArray);
            if($translation->save(false)){
                Yii::app()->user->setFlash('meta-success',Yii::t('backend','Метаданные обновлены'));
                $this->redirect($this->createUrl('/backend/gallery/gallery/imageEdit',['id'=>$translation->t_id,'language'=>Yii::app()->language]));
            } else {
                Yii::app()->user->setFlash('meta-error',Yii::t('backend','Ошибка сохранения метаданных'));
                $this->redirect($this->createUrl('/backend/gallery/gallery/imageEdit',['id'=>$translation->t_id,'language'=>Yii::app()->language]));
            }
        }

        $this->render('imageEdit',['model'=>$model,'parent'=>$parent]);
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
//	public function actionDelete($id)
//	{
//		$this->loadModel($id)->delete();
//
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Gallery',[
            'criteria'=>[
                'with'=>'translation',
                'condition'=>'level=1'
            ]
        ]);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
//	public function actionAdmin()
//	{
//		$model=new Gallery('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['Gallery']))
//			$model->attributes=$_GET['Gallery'];
//
//		$this->render('admin',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Gallery the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Gallery::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

//    public function loadMultilangModel($id,$lang)
//    {
//        $model = Gallery::model()
//            ->with(array(
//                'translation'=>array(
//                    'joinType'=>'LEFT JOIN',
//                    'on'=>'translation.t_language=:lang',
//                    'params'=>array(':lang'=>$lang),
//                )))->findByAttributes(array('id'=>$id));
//        return $model;
//    }

	/**
	 * Performs the AJAX validation.
	 * @param Gallery $model the model to be validated
	 */
//	protected function performAjaxValidation($model)
//	{
//		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//	}

    public function actionTest()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $name = Yii::app()->request->getParam('name');
            $entity = Yii::app()->request->getParam('entity');
            $entityid = Yii::app()->request->getParam('entityid');

            Yii::import('application.backend/modules.pages.models.'.$entity);
            $model = $entity::model()->findByPk($entityid);

            $widgetId = $name ? Translit::cyrillicToLatin($name) : rand(0,99999);

            if($id){
                $this->renderPartial('_testView',['widgetId'=>$widgetId,'model'=>$model],false,true);
            } else {
                echo 'error occured';
            }
        }

    }
}

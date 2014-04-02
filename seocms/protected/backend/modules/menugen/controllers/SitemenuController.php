<?php

class SitemenuController extends Controller
{
    public $layout = '//layouts/main';
    public $taskArray = array();

    public function init() {
        $this->registerAssets();
        parent::init();
    }

    private function registerAssets()
    {
        $this->registerJs('webroot.js_plugins.jstree','/jquery.jstree.js');
        $this->registerCssAndJs('webroot.js_plugins.fancybox',
            '/jquery.fancybox-1.3.4.js',
            '/jquery.fancybox-1.3.4.css');
        $this->registerCssAndJs('webroot.js_plugins.jqui1812',
            '/js/jquery-ui-1.8.12.custom.min.js',
            '/css/dark-hive/jquery-ui-1.8.12.custom.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/json2/json2.js');
    }

    //UTILITY FUNCTIONS
    public static  function registerCssAndJs($folder, $jsfile, $cssfile) {
        $sourceFolder = YiiBase::getPathOfAlias($folder);
        $publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerScriptFile($publishedFolder . $jsfile, CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($publishedFolder . $cssfile);
    }

    public static function registerCss($folder, $cssfile) {
        $sourceFolder = YiiBase::getPathOfAlias($folder);
        $publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerCssFile($publishedFolder .'/'. $cssfile);
        return $publishedFolder .'/'. $cssfile;
    }

    public static function registerJs($folder, $jsfile) {
        $sourceFolder = YiiBase::getPathOfAlias($folder);
        $publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerScriptFile($publishedFolder .'/'.  $jsfile);
        return $publishedFolder .'/'. $jsfile;
    }


    public function filters()
    {
        return array(
//            'rights',
            array('auth.filters.AuthFilter'),
        );
    }

	public function actionIndex()
	{
      $block = $this->drawMenuBlock();

		$this->render('index',array(
            'block'=>$block
        ));
	}

    public function actionCreatemenu()
    {
        if(Yii::app()->request->isAjaxRequest){
            $name = isset($_POST['menuName']) ? $_POST['menuName'] : null;
            if($name)

            $model = Yii::app()->db->createCommand()
                ->select('type')
                ->from('site_menu')
                ->where('type=:type',array(':type'=>$name))
                ->queryScalar();

            if(!empty($model)){
                echo CJSON::encode("false");
            } else {
                $model = new Sitemenu;
                $model->type = $name;

                if($model->saveNode()){
                    echo CJSON::encode("true");
                }else {
                    echo CJSON::encode("false");
                }
            }
        }
    }

    public function actionDeleteMenu()
    {
       $type = isset($_POST['type']) ? $_POST['type'] : null;
       if(!$type){
           echo CJSON::encode("bad type");
       } else {
           $id = Yii::app()->db->createCommand()
               ->select('id')
               ->from('site_menu')
               ->where('lft=1 AND type=:type',array(':type'=>$type))
               ->queryScalar();
           if(!(int)$id){
               echo CJSON::encode("bad id");
           } else {
               $model = Sitemenu::model()->findByPk($id);
               if($model->deleteNode()){
                   echo CJSON::encode("success");
               } else {
                   echo CJSON::encode("error deleting node");
               }
           }
       }
    }

    public function actionAjaxMenuBlock()
    {
        $block = $this->drawMenuBlock();
        echo CJSON::encode($block);
    }

    private function drawMenuBlock($type=null)
    {
            $model = Yii::app()->db->createCommand()
                ->selectDistinct('type,t_text')
                ->from('site_menu')
                ->leftJoin('sitemenu_translate','sitemenu_translate.source_id=site_menu.id')
                ->where('site_menu.lft=1 AND sitemenu_translate.t_lang=:lang',array(':lang'=>Yii::app()->language))
                ->queryAll();
        return $model;
    }

    public function actionView($type)
    {
//        $criteria = new CDbCriteria;
//        $criteria->condition = "type=:menu AND lft!='1'";
//        $criteria->params = array(':menu'=>$type);
//        $criteria->order = 'lft';
//        $menu = Sitemenu::model()->with(array('translation'=>array(
//            'joinType'=>'LEFT JOIN',
//            'on'=>'translation.t_lang=:lang',
//            'params'=>array(':lang'=>Yii::app()->language),
//        )))->findAll($criteria);
        $data = Sitemenu::model()->findByAttributes(['type'=>$type]);
        $model = Sitemenu::model()->findByPk($data->root);
        $_SESSION['css'] = Sitemenu::model()->getCss();

        $this->render('view', array(
//                'menu'=>$menu,
                'css'=>$_SESSION['css'],
                'model'=>$model,
                'type'=>$type,
            )
        );
    }

    public function actionChangeType()
    {

        Yii::import('backend.modules.pages.models.PagesTranslate');
        Yii::import('backend.modules.pages.models.StaticPages');


        Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
        $id = Yii::app()->request->getPost('model_id',null);
        $link_type = Yii::app()->request->getPost('link_type',null);

        if(isset($_POST['cancel']))
        {
            $this->redirect($this->createUrl('backend/menugen/sitemenu/mainmenu',array('language'=>Yii::app()->language)));

        }
        if(isset($_POST['confirm'])){
            $postArray = $_POST;
            $this->doUpdateMenu($postArray,false);
        }
        if(isset($_POST['save'])){
            $postArray = $_POST;
            $this->doUpdateMenu($postArray,true);
        }

        if($id){
            $model = $this->loadModel($id);
            $model->scenario = ucfirst($link_type);

            $parent = $model->parent()->find();

            $prev = $model->prev()->find() ? $model->prev()->find() : $model->parent()->find();

            $list = Sitemenu::getTreeListData('mainmenu');
            unset($list[$model->id]);

            $this->renderPartial('_form'.ucfirst($link_type),array(
                'model'=>$model,
                'parent'=>$parent,
                'listData'=>$list,
                'previous'=>$prev,
            ));
        }
    }

    public function actionSidemenu()
    {
        $baseUrl=Yii::app()->request->baseUrl;
        $this->render('sidemenu',array(
            'baseUrl'=>$baseUrl,
        ));
    }

    public function actionMainmenu()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "type='mainmenu' AND lft!='1'";
        $criteria->order = 'lft';
        $menu = Sitemenu::model()->with(array('translation'=>array(
            'joinType'=>'LEFT JOIN',
            'on'=>'translation.t_lang=:lang',
            'params'=>array(':lang'=>Yii::app()->language),
                                        )))->findAll($criteria);
        $_SESSION['css'] = Sitemenu::model()->getCss();

        $this->render('mainmenu', array(
                'menu'=>$menu,
                'css'=>$_SESSION['css'],
                'model'=>$menu,
            )
        );
    }


    public function actionFootermenu()
    {
        $this->render('footermenu');
    }

    public function loadModel($id)
    {
        $model=  Sitemenu::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }



    public function actionTranslateActions()
    {
        $source = isset($_POST['SourceMsg']) ? $_POST['SourceMsg'] : 'No source message';
        Yii::import('backend.modules.multilanguage.models.SourceMessage');
        Yii::import('backend.modules.multilanguage.models.Message');

        $model = SourceMessage::model()->findByAttributes(array('category'=>'backend','message'=>$source));

        $translate  = empty($model) ? new SourceMessage : $model;
        $translate->category = 'backend';
        $translate->message = $source;

        if($translate->save(false))
        {
            Yii::app()->user->setFlash('menu_success',Yii::t('backend','Saved '.$source));
            $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
        } else {
            Yii::app()->user->setFlash('menu_error',Yii::t('backend','Not saved, error occured!'));
            $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
        }
    }

    public function actionRemove(){
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

        if($id)
            $deleted_cat=$this->loadModel($id);
        else
            throw new CHttpException('404',Yii::t('backend','Передан несуществующий id записи'));

        if ($deleted_cat->deleteNode()){
            echo json_encode (array('wellDone'=>true));
        } else {
            echo json_encode (array('wellDone'=>false));
        }
    }


    public function actionFetchTree(){
        Sitemenu::printULTree();
    }

    /* tree modifications */

    public function actionMoveCopy(){

        $moved_node_id=$_POST['moved_node'];
        $new_parent_id=$_POST['new_parent'];
        $new_parent_root_id=$_POST['new_parent_root'];
        $previous_node_id=$_POST['previous_node'];
        $next_node_id=$_POST['next_node'];
        $copy=$_POST['copy'];

        //the following is additional info about the operation provided by
        // the jstree.It's there if you need it.See documentation for jstree.

        //  $old_parent_id=$_POST['old_parent'];
        //$pos=$_POST['pos'];
        //  $copied_node_id=$_POST['copied_node'];
        //  $replaced_node_id=$_POST['replaced_node'];

        //the  moved,copied  node
        $moved_node=$this->loadModel($moved_node_id);

        //if we are not moving as a new root...
        if ($new_parent_root_id!='root') {
            //the new parent node
            $new_parent=$this->loadModel($new_parent_id);
            //the previous sibling node (after the move).
            if($previous_node_id!='false')
                $previous_node=$this->loadModel($previous_node_id);


//if we move
            if ($copy == 'false'){


                //if the moved node is only child of new parent node
                if ($previous_node_id=='false'&&  $next_node_id=='false')
                {

                    if ($moved_node->moveAsFirst($new_parent)){
                        echo json_encode(array('success'=>true));
                        exit;
                    }
                }

                //if we moved it in the first position
                else if($previous_node_id=='false' &&  $next_node_id !='false')
                {

                    if($moved_node->moveAsFirst($new_parent)){
                        echo json_encode(array('success'=>true));
                        exit;
                    }
                }
                //if we moved it in the last position
                else if($previous_node_id !='false' &&  $next_node_id == 'false')
                {

                    if($moved_node->moveAsLast($new_parent)){
                        echo json_encode(array('success'=>true));
                        exit;
                    }
                }
                //if the moved node is somewhere in the middle
                else if($previous_node_id !='false' &&  $next_node_id != 'false')
                {

                    if($moved_node->moveAfter($previous_node)){
                        echo json_encode(array('success'=>true));
                        exit;
                    }

                }

            }//end of it's a move
            //else if it is a copy
            else{
                //create the copied UserMenu model
                $copied_node=new Usersmenu;
                //copy the attributes (only safe attributes will be copied).
                $copied_node->attributes=$moved_node->attributes;
                //remove the primary key
                $copied_node->id=null;


                if($copied_node->appendTo($new_parent)){
                    echo json_encode(array('success'=>true,
                            'id'=>$copied_node->primaryKey
                        )
                    );
                    exit;
                }
            }


        }//if the new parent is not root end
//else,move it as a new Root
        else{
            //if moved/copied node is not Root
            if(!$moved_node->isRoot())  {

                if($moved_node->moveAsRoot()){
                    echo json_encode(array('success'=>true ));
                }else{
                    echo json_encode(array('success'=>false ));
                }

            }
            //else if moved/copied node is Root
            else {

                echo json_encode(array('success'=>false,'message'=>'Node is already a Root.Roots are ordered by id.' ));
            }
        }

    }//action moveCopy


    public function actionCreate(){

        if(isset($_POST['Sitemenu']))
        {
            $model=new Sitemenu;
            //set the submitted values
            $model->attributes=$_POST['Sitemenu'];
            $parent=$this->loadModel($_POST['parent_id']);
//            $model->id = $_POST['Usersmenu']['id'];
            $model->type = $_POST['Sitemenu']['type'];
//            $model->text = $_POST['Sitemenu']['text'];
            //return the JSON result to provide feedback.
            if($model->appendTo($parent)){
                echo json_encode(array('success'=>true,
                        'id'=>$model->primaryKey)
                );
                exit;
            } else
            {
                echo json_encode(array('success'=>false,
                        'message'=>'Error.Sitemenu was not created.'
                    )
                );
                exit;
            }
        }
    }

    public function actionUpdate(){

        if(isset($_POST['Usersmenu']))
        {

            $model=$this->loadModel($_POST['id']);
            $model->attributes=$_POST['Usersmenu'];

            if( $model->saveNode(false)){
                echo json_encode(array('success'=>true));
            }else echo json_encode(array('success'=>false));
        }

    }

    public function actionUpdatemenu()
    {
        Yii::import('backend.modules.pages.models.PagesTranslate');
        Yii::import('backend.modules.pages.models.StaticPages');


//        Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;

        if(isset($_POST['save']))
            $action = 'save';

        if(isset($_POST['confirm']))
            $action = 'confirm';


        if(isset($_POST['cancel']))
            $action = 'cancel';

        if(isset($action))
        {
            $postArray = $_POST;
            $this->submit($action,$postArray);
        }

        $id = Yii::app()->request->getParam('id');

        if($id){
            $model = $this->loadModel($id);
            $model->scenario = ucfirst($model->link_type);

            $parent = $model->parent()->find();

            $prev = $model->prev()->find() ? $model->prev()->find() : $model->parent()->find();

            $list = Sitemenu::getTreeListData($model->type);
                unset($list[$model->id]);

            $this->render('updatemenu',array(
                'model'=>$model,
                'parent'=>$parent,
                'listData'=>$list,
                'previous'=>$prev,
            ));
//            $this->render('createItem');
        }

    }

    /**
     * ajax-method
     */
    public function actionDropdown()
    {
        $parent = (int)Yii::app()->request->getParam('parent',null);
//        $modelid = Yii::app()->request->getPost('model',null);
        $model = Sitemenu::model()->findByPk($parent);
        if($parent){
            echo self::getTreeDropDown($parent,$model,$model->type);
        }
    }

    public static function getTreeDropDown($parent,$model,$type)
    {
        $root = Sitemenu::model()->findByAttributes(array('lft'=>1,'type'=>$type));

        if($parent){
            $parentModel = Sitemenu::model()->with(array('translation'=>array(
                'joinType'=>'LEFT JOIN',
                'on'=>'translation.t_lang=:lang',
                'params'=>array(':lang'=>Yii::app()->language),
            )))->findByPk($parent);

            $arr = $parentModel->children()->findAll();
        } else {
            $arr = $root->children()->findAll();
            if(empty($arr))
                $arr = array();
        }

            $listArr = array();


            foreach($arr as $key=>$element){
                $listArr[$element->id] = $element->translation[Yii::app()->language]->t_text;
                    unset($listArr[$model->id]);

            }
        $prev = !$model->isNewRecord ? $model->prev()->find() : '';

        return CHtml::dropDownList('after',$prev,$listArr
            ,array('empty'=>Yii::t('backend','Первым'))
        );
    }

    public function actionCreateitem()
    {
        Yii::import('backend.modules.pages.models.PagesTranslate');
        Yii::import('backend.modules.pages.models.StaticPages');


        if(isset($_POST['save']))
            $action = 'save';

        if(isset($_POST['confirm']))
            $action = 'confirm';


        if(isset($_POST['cancel']))
            $action = 'cancel';

        if(isset($action)) {
            $postArray = $_POST;
            $this->submit($action,$postArray);
        }

        /* draws the ajax button*/
        if(!Yii::app()->request->isAjaxRequest) {
            $this->render('createItem');
        } else { /* create formm with model */
            $type = Yii::app()->request->getParam('menuName') ? Yii::app()->request->getParam('menuName') : null;
            $contentType = Yii::app()->request->getParam('linkType');
            $model = new Sitemenu;
            $model->scenario = ucfirst($contentType);
            $model->type = $type;

            $list = Sitemenu::getTreeListData($type);

             $root = Sitemenu::model()->findByAttributes(array('type'=>$model->type,'lft'=>1));

                $parent = !$model->isNewRecord ? $model->parent()->find() : null;
                $prev = !$model->isNewRecord ? $model->prev()->find() : null;

            $this->renderPartial('_form'.$model->scenario,array(
                'model'=>$model,
                'root'=>$root,
                'parent'=>$parent,
                'previous'=>$prev,
                'listData'=>$list,
            ));
        }
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='pagecreate-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function submit($action,$postArray)
    {
        $redirect = isset($postArray['Sitemenu']['type']) ? $postArray['Sitemenu']['type'] : null;
        if($redirect){
            switch($action){
                case 'save':
                    $this->doUpdateMenu($postArray,$redirect);
                    break;
                case 'confirm':
                    $this->doUpdateMenu($postArray,$redirect);
                    break;
                case 'cancel':
                    $this->redirect($this->createUrl('backend/menugen/sitemenu/view',array('type'=>$redirect,'language'=>Yii::app()->language)));
                    break;
                default:
                    throw new CHttpException('404','no redirect page');
            }
        } else {
            throw new CHttpException('404','no redirect page found');
        }
    }

    /**
     * @param $postArray (array $_POST)
     * this method gets data from $_POST,loads model,changes its position in tree
     * @param bool $redirect (if true - redirect, false - reload)
     */

    private function doUpdateMenu($postArray,$redirect)
    {
        $postparent = isset($postArray['Sitemenu']['parent']) ? (int)$postArray['Sitemenu']['parent'] : null;
        $postafter = isset($postArray['after']) ? (int)$postArray['after'] : null;
        $itemid = isset($postArray['itemid']) ? (int)$postArray['itemid'] : null;

        $model = $itemid ? $this->loadModel($itemid) : new Sitemenu;
        $model->link_type = $postArray['Sitemenu']['link_type'];
        $model->type = $redirect;

        $model->saveNode();

        $after = $postafter !== null ? Sitemenu::model()->findByPk($postafter) : $postafter;
        $newParent = Sitemenu::model()->findByPk($postparent);
        if($after)
        {
            $model->moveAfter($after);
        } else {
            $model->moveAsFirst($newParent);
        }
        /* if isset redirect - we should redirect to another level, if not - save and back to current page */
        $openNodes = Yii::app()->session['openNodes'];
        if(is_array($openNodes)){
            array_push($openNodes,$model->id);
            Yii::app()->session['openNodes'] = $openNodes;
        }

        $redirectUrl = 'backend/menugen/sitemenu/view';
            $this->redirect($this->createUrl($redirectUrl,array('language'=>Yii::app()->language,'type'=>$redirect)));
    }


    public function actionGetTranslit()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $pageid = Yii::app()->request->getPost('pageid',null);
            $lang = Yii::app()->request->getPost('lang',null);
            if($pageid)
            {
                $connection = Yii::app()->db;
                if($lang){
                    $sql = 'select page_id, t_lang, t_title as t_text, t_translit as t_url, published as t_hide from translate_pages where page_id=:pageid AND t_lang=:lang';
                    $command = $connection->createCommand($sql);
                    $command->bindParam(':pageid',$pageid,PDO::PARAM_INT);
                    $command->bindParam(':lang',$lang,PDO::PARAM_INT);
                }
                else {
                    $sql = 'select page_id, t_lang, t_title as t_text, t_translit as t_url, published as t_hide from translate_pages where page_id=:pageid';
                    $command = $connection->createCommand($sql);
                    $command->bindParam(':pageid',$pageid,PDO::PARAM_INT);
                }

                $arr = $command->queryAll();
                foreach($arr as $key=>$value)
                {
                    $newArr[$value['t_lang']]=$value;

                }
                echo CJSON::encode($newArr);
                Yii::app()->end();
            }
            echo CJSON::encode('error');
        }

    }

    public function actionLoadData()
    {

        if(isset($_POST['element'])) {
            $field = $_POST['element'];
        }
        if($_POST['element'] == 't_text')
            $attr = 't_title';
        else if($_POST['element'] == 't_hide')
            $attr = 'published';

        $language = isset($_POST['language']) ? $_POST['language'] : null;
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        $data = Yii::app()->db->createCommand()
            ->select($attr)
            ->from('translate_pages')
            ->where('page_id=:id AND t_lang=:lang',array(':id'=>$id,':lang'=>$language))
            ->queryScalar();

        $response = array(
            'dat'=>$data,
            'attrbt'=>$field,
            'lang'=>$language
        );

        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionToglemenu()
    {
        $id = isset($_POST['itemid']) ? (int)$_POST['itemid'] : null;
        $state = isset($_POST['state']) ?
            ((int)$_POST['state'] == 0) ? 1 : 0
                                        : null;
        $language = isset($_POST['language']) ? $_POST['language'] : null;

        if($id && is_int($state))
        {
            $model = Sitemenu::model()->findByPk($id);
            $children = $model->descendants()->findAll();
            $itemArray[] = $model->id;

            foreach($children as $key=>$child){
                    $itemArray[] = $child->id;
                }

            if($state == '1'){
                $model = SitemenuTranslate::model();
                $transaction = $model->dbConnection->beginTransaction();

                try {
                    $sql = Yii::app()->db->createCommand()
                        ->update('sitemenu_translate',array('t_hide'=>'2'),array('and','t_lang=:lang AND t_hide=1',array('in','source_id',$itemArray)),array(':lang'=>Yii::app()->language));

                    $sql1 = Yii::app()->db->createCommand()
                        ->update('sitemenu_translate',array('t_hide'=>'1'),array('and','t_lang=:lang AND t_hide=0',array('in','source_id',$itemArray)),array(':lang'=>Yii::app()->language));

                    $transaction->commit();

                } catch(Exception $e){
                    $transaction->rollback();
                }

            } elseif($state == '0') {
                $model = SitemenuTranslate::model();
                $transaction = $model->dbConnection->beginTransaction();

                try{
                    $sql = Yii::app()->db->createCommand()
                        ->update('sitemenu_translate',array('t_hide'=>'0'),array('and','t_lang=:lang AND t_hide=1',array('in','source_id',$itemArray)),array(':lang'=>Yii::app()->language));

                    $sql1 = Yii::app()->db->createCommand()
                        ->update('sitemenu_translate',array('t_hide'=>'1'),array('and','t_lang=:lang AND t_hide=2',array('in','source_id',$itemArray)),array(':lang'=>Yii::app()->language));

                    $transaction->commit();

                } catch(Exception $e){
                    $transaction->rollback();
                }
            }

            if(isset($sql)) {

                $all = Yii::app()->db->createCommand()
                    ->select('source_id,t_hide')
                    ->from('sitemenu_translate')
                    ->where(array('and','t_lang=:lang',array('in','source_id',$itemArray)),array(':lang'=>Yii::app()->language))
                    ->queryAll();

                echo CJSON::encode(array(
                            'isItRight'=>true,
                            'rowid'=>$id,
                            'state'=>$state,
                            'itemArray'=>$itemArray,
                            'all'=>$all,
                            ));
                Yii::app()->end();
            } else {
                echo CJSON::encode(array(
                            'isItRight'=>false,
                            'state'=>$state,
                            'rowid'=>$id,
                            ));
                Yii::app()->end();
            }

        }
    }


    public function actionRename(){

        $new_name=$_POST['new_name'];
        $id=$_POST['id'];
        $renamed_cat=$this->loadModel($id);
        $renamed_cat->text= $new_name;
        if ($renamed_cat->saveNode()){
            echo json_encode (array('success'=>true));
            exit;
        }else{
            echo json_encode (array('success'=>false));
            exit;
        }
    }

    public function actionReturnForm(){
        Yii::import('backend.modules.pages.models.PagesTranslate');
        Yii::import('backend.modules.pages.models.StaticPages');
        //don't reload these scripts or they will mess up the page
        //yiiactiveform.js still needs to be loaded that's why we don't use
        // Yii::app()->clientScript->scriptMap['*.js'] = false;
        $cs=Yii::app()->clientScript;
        $cs->scriptMap=array(
            'jquery.min.js'=>false,
            'jquery.js'=>false,
            'jquery.fancybox-1.3.4.js'=>false,
            'jquery.jstree.js'=>false,
            'jquery-ui-1.8.12.custom.min.js'=>false,
            'json2.js'=>false,

        );


        //Figure out if we are updating a Model or creating a new one.
        if(isset($_POST['update_id']))$model= $this->loadModel($_POST['update_id']);
        else $model=new Sitemenu;

        $this->renderPartial('_form', array(
            'model'=>$model,
            'parent_id'=>!empty($_POST['parent_id']) ? $_POST['parent_id'] : '',
            'id'=>!empty($_POST['id']) ? $_POST['id'] : '',
            'type'=>!empty($_POST['type']) ? $_POST['type'] : '',
        ),false, true);
    }

    public function actionReturnView(){
        //don't reload these scripts or they will mess up the page
        //yiiactiveform.js still needs to be loaded that's why we don't use
        // Yii::app()->clientScript->scriptMap['*.js'] = false;
        $cs=Yii::app()->clientScript;
        $cs->scriptMap=array(
            'jquery.min.js'=>false,
            'jquery.js'=>false,
            'jquery.fancybox-1.3.4.js'=>false,
            'jquery.jstree.js'=>false,
            'jquery-ui-1.8.12.custom.min.js'=>false,
            'json2.js'=>false,
        );
        $model=$this->loadModel($_POST['id']);

        $this->renderPartial('view', array(
            'model'=>$model,
        ),false, true);
    }

    public function actionAjaxMenuGrid(){

        $nodes = isset($_POST['openNodes']) ? $_POST['openNodes'] : null;
        $output = isset($_POST['output']) ? true : false;

        if(!$output){
            Yii::app()->session['openNodes'] = $nodes;
        } else {
            $rowsArray = isset($_POST['children']) ? explode(',',$_POST['children']) : null;
            Yii::app()->session['openNodes'] = array_unique(array_merge($nodes,$rowsArray));

            /*нет проверки на null: во вьшке параметр children есть тольку у тех у кого есть дочерние элементы*/

            /*order lft desc переворачивает дерево, чтобы было проще в js делать insertAfter, иначе ломает порядок*/

            $data = Yii::app()->db->createCommand()
                ->select()
                ->from('sitemenu_translate')
                ->leftJoin('site_menu','sitemenu_translate.source_id=site_menu.id')
                ->where(array('and','t_lang=:lang',array('in','source_id',$rowsArray)),array(':lang'=>Yii::app()->language))
                ->order('lft desc')
                ->queryAll();

            $childrenArray = array();

                /*explode always returns an array so no need to check if is_array*/
                foreach($rowsArray as $key=>$value){
                    $model = Sitemenu::model()->findByPk($value);
                    $parent = $model->parent()->find();
                    $childrenArray[$model->id]['id'] = $model->id;

                    $children = Yii::app()->db->createCommand()
                        ->select()
                        ->from('site_menu')
                        ->where(array('and','lft>:lft','rgt<:rgt','root=:root','level=:level')
                            ,array(':lft'=>$model->lft,':rgt'=>$model->rgt,':level'=>$model->level+1,':root'=>$model->root))
                        ->queryAll();

                    $descendants = Yii::app()->db->createCommand()
                        ->select()
                        ->from('site_menu')
                        ->where(array('and','lft>:lft','rgt<:rgt','root=:root')
                            ,array(':lft'=>$model->lft,':rgt'=>$model->rgt,':root'=>$model->root))
                        ->queryAll();

                    foreach($children as $key=>$value){
                        $children[$key] = $value['id'];
                    }

                    foreach($descendants as $key=>$value){
                        $descendants[$key] = $value['id'];
                    }

                    $childrenArray[$model->id]['children'] = $children;
                    $childrenArray[$model->id]['descendants'] = $descendants;
                }

            $response = array('data'=>$data,'descendants'=>$childrenArray,'parent'=>$parent->id);
            echo CJSON::encode($response);
        }
    }
}
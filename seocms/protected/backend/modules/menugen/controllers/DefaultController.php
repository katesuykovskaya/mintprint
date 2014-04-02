<?php

class DefaultController extends Controller
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
//        $this->registerCssAndJs('webroot.js_plugins.jqui1812',
//            '/js/jquery-ui-1.8.12.custom.min.js',
//            '/css/dark-hive/jquery-ui-1.8.12.custom.css');
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
		$this->render('index');
	}

    public function actionUsermenu()
    {
        $this->render('usermenu');
    }

    public function loadModel($id)
    {
        $model = Usersmenu::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function actionAjaxUserItems()
    {
        $role = isset($_POST['dropname']) ? $_POST['dropname'] : 'no POST[dropname]';

        if($role) {

            $new = $this->createAuthArray($role);
            $menuArray = Usersmenu::model()->findAllByAttributes(array('role'=>$role));
            $visArray = Usersmenu::model()->findAllByAttributes(array('role'=>$role,'visible'=>1));

            $workArray = array();
            $visibleArray = array();

            foreach($menuArray as $obj) {
                    $workArray[] = $obj->text;
            }

            foreach($visArray as $obj2) {
                $visibleArray[] = $obj2->text;
            }

            echo '<ul>';
            foreach($new as $key=>$action) {

                if(in_array($action,$workArray)) {
                    if(in_array($action,$visibleArray)) {
                        echo '<li>';
                            echo CHtml::checkBox($action,true,array('value'=>$action));
                            echo CHtml::link(' <i class="icon-thumbs-up"></i> ',array('#'),array(
                            'data-toggle'=>'tooltip',
                            'title'=>$action,
                        ));
                        echo CHtml::link(Yii::t('backend',$action),'#',array('class'=>'modalLink','data-action'=>$action));
                        echo '</li>';
                    } else {
                        echo '<li>';
                        echo CHtml::checkBox($action,false,array('value'=>$action));
                        echo CHtml::link(' <i class="icon-eye-close"></i> ',array('#'),array(
                            'data-toggle'=>'tooltip',
                            'title'=>$action,
                        ));
                        echo CHtml::link(Yii::t('backend',$action),'#',array('class'=>'modalLink','data-action'=>$action));
                        echo '</li>';
                    }
                } else {
                    echo '<li>';
                        echo CHtml::checkBox($action,false,array('value'=>$action));
                        echo CHtml::link(' <i class="icon-fire"></i> ',array('#'),array(
                            'data-toggle'=>'tooltip',
                            'title'=>$action,
                        ));
                    echo CHtml::link(Yii::t('backend',$action),'#',array('class'=>'modalLink','data-action'=>$action));
                    echo '</li>';
                }
            }
            echo '</ul>';
            $model = Usersmenu::model()->findAllByAttributes(array('role'=>$role));
            if(!empty($model))
                echo CHtml::submitButton(Yii::t('backend','Update'),array('class'=>'btn','name'=>'Update'));

        }
    }

    public function actionTranslateActions()
    {

        if(!Yii::app()->request->isAjaxRequest){
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
        } else {
            $action = isset($_POST['phrase']) ? $_POST['phrase'] : null;
//            $model = SourceMessage::model()->findByAttributes(array('category'=>'backend','message'=>$action));
            $id = Yii::app()->db->createCommand()
                ->select('id')
                ->from('SourceMessage')
                ->where('message=:message',array(':message'=>$action))
                ->queryScalar();
            $modelTranslations = Yii::app()->db->createCommand()
                ->select('language,translation')
                ->from('Message')
                ->where('id=:id',array(':id'=>$id))
                ->queryAll();
            $arr = array();
            $arr['sourceMsg'] = $action;
            $arr['translateMsgs'] =$modelTranslations;
            echo CJSON::encode($arr);

        }


    }

    private function createAuthArray($role)
    {
//        $authorizer = Rights::getAuthorizer();
//        $permisions = $authorizer->getPermissions($role);
        $pattern ='^[a-z,A-Z]\.[a-z,A-Z]?^';
//        foreach ($permisions as $key=>$value) {
//            if(preg_match($pattern, $key)) {
//                $this->taskArray[] = $key;
//            } else {
//                $this->taskArray = $this->createAuthArray($key);
//            }
//        }

//        $testArr = [];
        $permissions = Yii::app()->db->createCommand()
            ->select('child')
            ->from('AuthItemChild')
            ->where('parent=:parent',[':parent'=>$role])
            ->queryAll();

//        echo CVarDumper::dump($permissions,5,true);

        if(!empty($permissions))
            foreach($permissions as $key=>$value) {
                $this->taskArray[] = $value['child'];
                if(preg_match($pattern, $value['child'])) {
                    unset($permissions[$key]);
                } else {
                    $this->taskArray = $this->createAuthArray($value['child']);
                }
            }

        return array_unique($this->taskArray);
    }


    public function actionPreviewMenu()
    {
        Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;

        $baseUrl=Yii::app()->request->baseUrl;
         if(Yii::app()->request->isAjaxRequest){
             $role = Yii::app()->request->getParam('dropname',null);

             $open_nodes = Usersmenu::model()->findAllbyAttributes(array('role'=>$role),'lft=1');

             $identifiers = array();
             foreach($open_nodes as $n=>$node)
             {
                 $identifiers[] = "'".'node_'.$node->id."'";
             }
             $open_nodes = implode(',',$identifiers);

                    if(!Yii::app()->session['menurole'])
                        Yii::app()->session->add('menurole',$role);
                     if(!Yii::app()->session['baseUrl'])
                         Yii::app()->session->add('baseUrl',$baseUrl);
                    if(!Yii::app()->session['open_nodes'])
                        Yii::app()->session->add('open_nodes',$open_nodes);

             Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;

             $this->renderPartial('_tree',array(
                 'role'=>$role,
                 'baseUrl'=>$baseUrl,
                 'open_nodes'=>$open_nodes,
             ),false,true);
         }
         else{
                 $role = Yii::app()->request->getParam('rolemenu',null);

                 $open_nodes = Usersmenu::model()->findAllbyAttributes(array('role'=>$role),'lft=1');

                 $identifiers = array();
                     foreach($open_nodes as $n=>$node)
                     {
                         $identifiers[] = "'".'node_'.$node->id."'";
                     }
                 $open_nodes = implode(',',$identifiers);

                     if(!Yii::app()->session['menurole'])
                         Yii::app()->session->add('menurole',$role);
                     if(!Yii::app()->session['baseUrl'])
                         Yii::app()->session->add('baseUrl',$baseUrl);
                     if(!Yii::app()->session['open_nodes'])
                         Yii::app()->session->add('open_nodes',$open_nodes);

                $model = Usersmenu::model()->findAllByAttributes(array('role'=>$role));


                if(isset($_POST['Create'])){
                    $this->createMenu($model,$role);
                }

                if(isset($_POST['Delete'])){
                        $this->deleteMenu($role);
                }

                if(isset($_POST['Update'])){
                    $role = isset($_POST['usermenu']) ? $_POST['usermenu'] : null;
                    $model = Usersmenu::model()->findAllByAttributes(array('role'=>$role));
                        $this->updateMenu($model,$role);
                }

                    $this->render('menuGen',array(
                        'role'=>$role,
                        'baseUrl'=>$baseUrl,
                        'open_nodes'=>$open_nodes,
                    ));
         }
    }

    public function actionRemove(){
        $id=$_POST['id'];
        $deleted_cat=$this->loadModel($id);

        if ($deleted_cat->deleteNode()){
            echo json_encode (array('success'=>true));
            exit;
        }else{
            echo json_encode (array('success'=>false));
            exit;
        }
    }

    private function updateMenu($model,$role)
    {
        unset($_POST['Update']);
        $updateArr = array();
        $updateArr = $_POST;
        if(!empty($updateArr))
        {

            $update = Usersmenu::model()->updateAll(array('visible'=>0),'role=:role AND lft!=1 AND url is not NULL',array(':role'=>$role));

            foreach($updateArr as $key=>$val)
            {
                $model = Usersmenu::model()->findByAttributes(array('text'=>$val,'role'=>$role));
                if(!$model)
                {
                    $root = Usersmenu::model()->findByAttributes(array('text'=>$role,'lft'=>1));
                    $newNode = new Usersmenu;
                    $newNode->text = $val;
                    $newNode->url = '/backend/'.strtolower(str_replace('.','/',$val));
                    $newNode->role = $role;
                    if($newNode->appendTo($root))
                        Yii::app()->user->setFlash('menu_success',Yii::t('backend','Saved'));
                    else
                        Yii::app()->user->setFlash('menu_error',Yii::t('backend','Not saved'));
                } else {
                    $model->visible = 1;
                    if($model->saveNode(false))
                        Yii::app()->user->setFlash('menu_success',Yii::t('backend','Saved'));
                    else
                        Yii::app()->user->setFlash('menu_error',Yii::t('backend','Not saved'));
                }
            }

            $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
        }
    }

    private function createMenu($model,$role)
    {
        If(!empty($model))
        {
            Yii::app()->user->setFlash('menu_error',Yii::t('backend','Menu already exists'));
            $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
        }
        $menuArr = $this->createAuthArray($role);

        $root = new Usersmenu();
        $root->text = $role;
        $root->role = $role;
        $root->saveNode();

        foreach($menuArr as $key=>$action)
        {
            $node = new Usersmenu();
            $node->text = $action;
            $node->role = $role;
            $node->url = strtolower(str_replace('.','/','backend/'.$action));
            $node->appendTo($root);
        }

        Yii::app()->user->setFlash('menu_success', Yii::t('backend','Menu was created!'));
        $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
    }

    private function deleteMenu($role)
    {
        $result = Usersmenu::model()->deleteAllByAttributes(array('role'=>$role));
        if($result)
        {
            Yii::app()->user->setFlash('menu_success', Yii::t('backend','Menu was deleted!'));
            $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
        } else {
            Yii::app()->user->setFlash('menu_error', Yii::t('backend','Menu was not deleted!'));
            $this->redirect($this->createUrl('backend/menugen/default/usermenu',array('language'=>Yii::app()->language)));
        }
    }

    public function actionFetchTree(){
        Usersmenu::printULTree();
    }

    public function actionMenuGen()
    {
        $role = isset($_POST['rolemenu']) ? $_POST['rolemenu'] : null;
        $baseUrl=Yii::app()->request->baseUrl;
        $this->render('menuGen',array(
            'baseUrl'=>$baseUrl,
            'role'=>$role,
        ));
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
                } else {
                    echo json_encode(array('success'=>false ));
                }

            } else { //else if moved/copied node is Root
                echo json_encode(array('success'=>false,'message'=>'Node is already a Root.Roots are ordered by id.' ));
            }
        }

    }//action moveCopy


    public function actionCreate(){
        if(isset($_POST['Usersmenu']))
        {
            $model=new Usersmenu;
            //set the submitted values
            $model->attributes=$_POST['Usersmenu'];
            $parent=$this->loadModel($_POST['parent_id']);
            $model->role = $_POST['Usersmenu']['role'];
            //return the JSON result to provide feedback.
            if($model->appendTo($parent)){
                echo json_encode(array('success'=>true,
                        'id'=>$model->primaryKey)
                );
                exit;
            } else {
                echo json_encode(array('success'=>false,
                        'message'=>'Error.UserMenu was not created.'
                    )
                );
                exit;
            }
        }
    }


    public function actionUpdate()
    {
        if(isset($_POST['Usersmenu'])){
            $model=$this->loadModel($_POST['id']);
            $model->attributes=$_POST['Usersmenu'];

            if( $model->saveNode(false)){
                echo json_encode(array('success'=>true));
            } else
                echo json_encode(array('success'=>false));
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

    public function actionReturnForm()
    {
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
        else $model=new Usersmenu;

        $this->renderPartial('_form', array(
            'model'=>$model,
            'parent_id'=>!empty($_POST['parent_id']) ? $_POST['parent_id'] : '',
            'id'=>!empty($_POST['id']) ? $_POST['id'] : '',
            'role'=>!empty($_POST['role']) ? $_POST['role'] : '',
        ),false, true);
    }

    public function actionReturnView()
    {
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

}
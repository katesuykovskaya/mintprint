<?php

class DefaultController extends Controller
{
    public $layout ='//layouts/main';

    public function filters()
    {
        return array(
            'rights'
        );
    }

	public function actionIndex()
	{
//        Yii::import('webroot.js_plugins.ace');
//        Yii::app()->clientScript->registerScriptFile('/var/www/seotm_cms/js_plugins/ace-editor/ace.js');
        $criteria = new CDbCriteria;
        $criteria->order = 'position';
        $model = SiteConfig::model()->findAll($criteria);
		$this->render('index',array(
            'model'=>$model
        ));
	}

    public function actionAjaxConfig()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_POST['id'])) ? (int)$_POST['id'] : null;
            $data = (isset($_POST['configValue'])) ? $_POST['configValue'] : null;

            if($id && $data){
                $model = SiteConfig::model()->findByPk($id);
                echo CJSON::encode($model->{$data});

            } else {
                echo CJSON::encode('error');
            }
        }

    }

    public function actionSaveData()
    {
        if(Yii::app()->request->isAjaxRequest){

            $operation = Yii::app()->request->getPost('operation');
            if($operation === 'edit'){
                $id = Yii::app()->request->getPost('id',null);
                $data = Yii::app()->request->getPost('newData',null);
                $model = SiteConfig::model()->findByPk((int)$id);
                $model->value = trim($data);
            } else {
                $model = new SiteConfig;
                $model->param = $_POST['param'];
                $model->value = trim($_POST['value']);
                $model->default = trim($_POST['default']);
                $model->label = $_POST['label'];
                $model->type = $_POST['type'];
                $model->data_type = $_POST['data_type'];
                $model->status = (isset($_POST['status'])) ? 'enabled' : 'disabled';
                $connection = Yii::app()->db;
                $sql = "select max(position) from SiteConfig";
                $q = $connection->createCommand($sql);
                $position = $q->queryScalar();
                $model->position = (int)$position +1;
                echo CJSON::encode($model->attributes);
            }

                if($model->save(false)){
                    Yii::app()->user->setFlash('success',Yii::t('backend','Изменения успешно внесены!'));
                    echo CJSON::encode('success');
                }

                else {
                    Yii::app()->user->setFlash('error',Yii::t('backend','Изменения не были внесены!'));
                    echo CJSON::encode('error');
                }
        }
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = Yii::app()->request->getPost('id',null);
            if($model = SiteConfig::model()->deleteByPk((int)$id)){
                echo CJSON::encode('success');
            } else {
                echo CJSON::encode('error');
            }
        }
    }

    public function actionPreview()
    {
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from('SiteConfig')
            ->order('position')
            ->queryAll();

        $params = array();

        foreach($model as $key=>$config){
            switch($config['type']){
                case('project parameter'):
                    $params[$config['param']] = trim($config['value']);
                    break;
                case('component'):
                    $params['components'][$config['param']] = trim($config['value']);
                    break;
            }
        }
        echo CJSON::encode($params);
    }

    public function actionReconfig()
    {
        $step = (int)$_POST['step'];
        switch($step){
            case(1):
                $data = $this->step1();
                echo CJSON::encode($data);
                break;
            case(2):
                $data = $this->step2();
                echo CJSON::encode($data);
                break;
            case(3):
                $data = $this->step3();
                echo CJSON::encode($data);
                break;
        }
    }

    private  function step1()
    {
        $falseResponse = array(
            'progress'=>30,
            'status'=>'error',
            'message'=>'<em class="alert alert-danger">smth wrong with backup dir</em>',
            'nextHop'=>false
        );
        if(is_readable(Yii::app()->basePath.'/backend/config/backup/')){
            $response = array(
                'progress'=>30,
                'status'=>'success',
                'message'=>'<em class="alert alert-success">directory exists and ready for backup</em>',
                'nextHop'=>true
            );
        } else {
            $response = $falseResponse;
        }
        return $response;
    }

    private function step2()
    {
        $config = Yii::app()->basePath.'/backend/config/main.php';
        $configSize = filesize($config);
        $backup = Yii::app()->basePath.'/backend/config/backup/'.time().'.php';
        $copy = copy($config,$backup);
        $backupSize = filesize($backup);
        if($configSize === $backupSize){
            $response = array(
                'progress'=>60,
                'status'=>'success',
                'message'=>'<em class="alert alert-success">backup file created successfully</em>',
                'nextHop'=>true
            );

        } else {
            $falseResponse = array(
                'progress'=>60,
                'status'=>'error',
                'message'=>'<em class="alert alert-danger">backup file was not created</em>',
                'nextHop'=>false
            );
        }
        return $response;
    }

    private function step3()
    {
        $config = Yii::app()->basePath.'/backend/config/main.php';
        $handle = fopen($config,'w+');
        if($handle){
            $criteria = new CDbCriteria;
            $criteria->order = 'position';
            $data = SiteConfig::model()->findAll($criteria);
            $params = '<?php'."\n".'Yii::setPathOfAlias(\'backend\', dirname(dirname(__FILE__)));'.
//                "\n".'return array('."\n";
                "\n".'return CMap::mergeArray('."\n".
                    '(require dirname(dirname(__FILE__))."/../common/config/main.php"), array('."\n";
//            $modules = "'modules'=>array(\n";
            $components = "'components'=>array(\n";
            foreach($data as $key=>$param){
                if($param->type === 'project parameter'){
                    $str1 = 'array(';
                    $str2 = 'require(';
                    $str3 = 'dirname(';

                    if(strpos($param->value,$str1) !== false
                        || strpos($param->value,$str2) !== false
                        || strpos($param->value,$str3) !== false) {
                        $params .= "'".$param->param."'=>".$param->value.",\n";
                    }

                    else
                        $params .= "'".$param->param."'=>'".$param->value."',\n";

                } elseif($param->type === 'component'){
                    $components .= "\t"."'".$param->param."'=>".$param->value.",\n";
                }
            }
//            if(file_put_contents($config,$params."\n".$modules."),\n".$components.')'."\n".');')){
            if(file_put_contents($config,$params."\n".$components.'),'."\n".'));')){
                $response = array(
                    'progress'=>100,
                    'status'=>'success',
                    'message'=>'<em class="alert alert-success">new config created successfully</em>',
                    'nextHop'=>false
                );
            };
        } else {
                echo "file handle error";
        }
        return $response;
    }

    public function actionGetList()
    {
        if(Yii::app()->request->isAjaxRequest){
            $position = (isset($_POST['pos'])) ? (int)$_POST['pos'] : null;
            if($position){
                $prev = Yii::app()->db->createCommand()
                    ->select('position')
                    ->from('SiteConfig')
                    ->where('position <'.$position)
                    ->order('position DESC')
                    ->limit('1')
                    ->queryScalar();
                echo CHtml::dropDownList(
                    'configParams',
                    $prev,
                    CHtml::listData(SiteConfig::model()->findAll(array('order'=>'position')),'position','param'),
                    array(
                        'empty'=>Yii::t('backend','На первую позицию')
                    )
                );
            }

        }
    }

    public function actionMove()
    {
        if(Yii::app()->request->isAjaxRequest){
            $move = (isset($_POST['move'])) ? (int)$_POST['move'] : null;

            $current = (isset($_POST['current'])) ? (int)$_POST['current'] : null;
            if($move !== null){
                $sql = "update SiteConfig set position = position +1 where position > ".$move." order by position DESC";
                $moveData = Yii::app()->db->createCommand($sql)->execute();
                if($moveData)
                    echo "success";
                else
                    echo "error moveData";

                if($current > $move)
                    $sql2 = "update SiteConfig set position = '".($move+1)."' where position='".($current+1)."'";
                else
                    $sql2 = "update SiteConfig set position = '".($move+1)."' where position='".($current)."'";
                $moveData2 = Yii::app()->db->createCommand($sql2)->execute();
                if($moveData2)
                    echo "success";
                else
                    echo "error moveData2";

            } else {
                echo "error move";
            }
        }
    }

}
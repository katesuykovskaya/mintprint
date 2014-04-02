<?php

class DefaultController extends Controller
{

	public function actionIndex()
	{
		$this->render('index',array(
        ));
	}

    public function actionCreate()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            Yii::import('application.backend.modules.attach.assets.server.php.UploadHandler');
            $upload_handler = new UploadHandler(true);
            Yii::app()->end();
        }
    }

    public function actionShow()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            Yii::import('application.backend.modules.attach.assets.server.php.FileHandler');
            $file_handler = new FileHandler(true);
            Yii::app()->end();
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

    public function actionHide()
    {
        if(Yii::app()->request->isAjaxRequest){
            $visible = isset($_POST['hidden']) ? (int)$_POST['hidden'] : null;
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
        if(is_int($visible) && is_int($id)){
            $command = Yii::app()->db->createCommand();
            $command->update('Attachments',array('hidden'=>($visible === 1) ? 0 : 1),'attachment_id=:id',array(':id'=>$id));
        }

        }
    }

    public function actionSort()
    {
        $fileSession = Yii::app()->session['files'];
        $current = (isset($_POST['current'])) ? (int)$_POST['current'] : null;
        $previous = (isset($_POST['previous'])) ? (int)$_POST['previous'] : null;
        $id = (isset($_POST['id'])) ? (int)$_POST['id'] : null;
        $entity = $fileSession['files']['entity'];
        $entity_id = $fileSession['files']['entity_id'];

        if(is_int($previous))
        {
            $updateRange = "update Attachments set position = position + 1 where position > '".$previous."' AND position < '".$current."' AND attachment_entity='".$entity."' AND entity_id='".$entity_id."'";
            Yii::app()->db->createCommand($updateRange)->execute();
            $updateCurrent = "update Attachments set position = '".($previous+1)."' where attachment_id='".$id."'";
            Yii::app()->db->createCommand($updateCurrent)->execute();
        } elseif($previous === "undefined") {
            $updateRange = "update Attachments set position = position + 1 where position > '0' AND position < '".$current."' AND attachment_entity='".$entity."' AND entity_id='".$entity_id."'";
            Yii::app()->db->createCommand($updateRange)->execute();
            $updateCurrent = "update Attachments set position = '1' where attachment_id='".$id."'";
            Yii::app()->db->createCommand($updateCurrent)->execute();
        } else {
            $updateRange = "update Attachments set position = position + 1 where position > '0' AND attachment_entity='".$entity."' AND entity_id='".$entity_id."'";
            Yii::app()->db->createCommand($updateRange)->execute();
            $updateCurrent = "update Attachments set position = '1' where attachment_id='".$id."'";
            Yii::app()->db->createCommand($updateCurrent)->execute();
        }
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='upload-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
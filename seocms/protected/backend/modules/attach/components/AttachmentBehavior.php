<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chosen1
 * Date: 22.10.13
 * Time: 12:11
 * To change this template use File | Settings | File Templates.
 */

class AttachmentBehavior extends CActiveRecordBehavior {


    public $entity_id;
    public $upload_path;

    /**
     * php delete function that deals with directories recursively
     * @param $target - directory path to work with
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

    /**
     * moves files from temporary to destination folder and writes them to DB
     * @param $tmpPath
     * @param $uploadDir
     * @param $model
     */
    protected function moveFiles($tmpPath,$uploadDir,$model)
    {
        $allFiles = is_dir($tmpPath) ? scandir($tmpPath,1) : null;
        if($allFiles){
            foreach($allFiles as $file){
                if(!is_dir($tmpPath.$file)){
                    $newPath = $uploadDir.$file;
                    if(is_dir($uploadDir)){
                        rename($tmpPath.$file,$newPath);
                    } else {
                        mkdir($uploadDir,0777,true);
                        rename($tmpPath.$file,$newPath);
                    }
                    Yii::import('application.backend.modules.attach.models.Attachment');
                    $modelExist = Attachment::model()->findByAttributes(array('path'=>$file,'entity_id'=>(int)$this->entity_id));

                    if(!$modelExist){
                        $fileExt = pathinfo($newPath,PATHINFO_EXTENSION);
                        $attachment = new Attachment;
                        $attachment->attachment_entity = get_class($this->owner);
                        $attachment->entity_id = $model;
                        $attachment->path = $file;

                        switch($fileExt){
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                                $attachment->type = 'image';
                                break;
                            case 'mp3':
                                $attachment->type = 'music';
                                break;
                            case 'mpeg4':
                            case 'avi':
                                $attachment->type = 'video';
                                break;
                            default :
                                $attachment->type = 'file';
                            break;
                        }

                        $sql = "select max(position)
                            from Attachments
                            where attachment_entity='".$attachment->attachment_entity."' and entity_id='".$attachment->entity_id."'";
                        $max = Yii::app()->db->createCommand($sql)->queryScalar();
                        $attachment->position = $max+1;
                        $attachment->save(false);
                    }

                } else {
                    if($file ==='.' || $file === '..') continue;
                    else
                        $this->moveFiles($tmpPath.$file.DIRECTORY_SEPARATOR,$uploadDir.$file.DIRECTORY_SEPARATOR,$model);
                }
            }
        }
    }

    /**
     * @param CModelEvent $event
     */
    public function afterSave($event)
    {
        if(isset(Yii::app()->session['files'])){
            $files = Yii::app()->session['files'];
            $tmpPath = $files['files']['tempUrl'];
            $uploadDir = $files['files']['uploadUrl'].$files['files']['entity'].DIRECTORY_SEPARATOR.$this->entity_id.DIRECTORY_SEPARATOR;

            $this->moveFiles($tmpPath,$uploadDir,$this->entity_id);

            unset(Yii::app()->session['files']);

            $this->delete_files($tmpPath);
        }
    }

    public function afterDelete($event)
    {
        $entity = get_class($this->owner);
        $entity_id = $this->owner->page_id;
        Attachment::model()->deleteAllByAttributes(array('attachment_entity'=>$entity,'entity_id'=>$entity_id));
        $this->delete_files($this->upload_path.$entity.DIRECTORY_SEPARATOR.$entity_id.DIRECTORY_SEPARATOR);
    }
}
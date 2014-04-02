<?php
/* @var $this PagesController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1 class="page-header">Static Pages</h1>

            <form method="post">
                <input type="text" class="mceEditor" />
            </form>
         <div id="wysiwyg">
            <?php
                $this->widget('application.backend.extensions.tinymce.TinyMceWidget',array(
                    'language'=>Yii::app()->language,
//                    'attribute'=>'mcEditor'
                ));
            ?>
          </div>
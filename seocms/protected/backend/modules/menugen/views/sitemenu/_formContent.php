    <?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>$model->getTranslateData(Yii::app()->params['languages'],$model->translateAttributes,$validators,$model),
    ));

        echo '<label>'.CHtml::label(Yii::t('backend','Родитель'),'parent').'</label>';
        echo CHtml::dropDownList('parent',$parent->id,$listData,
                            array(
                                'ajax'=>array(
                                    'type'=>'post',
                                    'url'=>$this->createUrl('/backend/menugen/sitemenu/dropdown',array('language'=>Yii::app()->language)),
                                    'update'=>'#after',
                                    'data' => array(
                                                'parent'=> 'js: $("#parent option:selected").val()',
                                                'model'=>$model->id,
                                                    )
                                ),
                            )
                        ).'<br />';

      echo '<label>'.CHtml::label(Yii::t('backend','Отображать после'),'after').'</label>';
      ?>
         <span id="after">
             <?php echo $this->getTreeDropDown($parent->id,$model);?>
         </span>
    <br />
    <?php
        echo CHtml::hiddenField('itemid',$model->id);
    ?>
<hr />

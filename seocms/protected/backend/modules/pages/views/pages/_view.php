<?php
/* @var $this PagesController */
/* @var $data StaticPages */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('page_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->page_id), array('view', 'id'=>$data->page_id)); ?>
	<br />
        
        <?php
           // echo CVarDumper::dump($data->translation, $depth=10, $highlight=true);
        
        foreach($data->translation as $related)
        {
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_title'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_title));echo '<br />';
	
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_h1'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_h1));echo '<br />';
	
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_desc'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_desc));echo '<br />';
	
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_content'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_content));echo '<br />';
	
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_mdesc'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_mdesc));echo '<br />';
	
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_mtitle'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_mtitle));echo '<br />';
	
            echo '<b>'.$related->t_lang.'</b>:<br />';
            echo CHtml::encode($related->getAttributeLabel('t_mkeywords'));echo ':';
            echo CHtml::encode(CHtml::encode($related->t_mkeywords));echo '<br />';
	
        }
        ?>

</div>
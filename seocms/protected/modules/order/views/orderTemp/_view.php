<?php
/* @var $this OrderTempController */
/* @var $data OrderTemp */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('session_id')); ?>:</b>
	<?php echo CHtml::encode($data->session_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_url')); ?>:</b>
	<?php echo CHtml::encode($data->img_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thumb_url')); ?>:</b>
	<?php echo CHtml::encode($data->thumb_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_count')); ?>:</b>
	<?php echo CHtml::encode($data->img_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_width')); ?>:</b>
	<?php echo CHtml::encode($data->img_width); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('img_height')); ?>:</b>
	<?php echo CHtml::encode($data->img_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_x')); ?>:</b>
	<?php echo CHtml::encode($data->img_x); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_y')); ?>:</b>
	<?php echo CHtml::encode($data->img_y); ?>
	<br />

	*/ ?>

</div>
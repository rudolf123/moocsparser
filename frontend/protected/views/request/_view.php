<?php
/* @var $this RequestController */
/* @var $data Request */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instructor_name_rus')); ?>:</b>
	<?php echo CHtml::encode($data->instructor_name_rus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instructor_name_eng')); ?>:</b>
	<?php echo CHtml::encode($data->instructor_name_eng); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_name_rus')); ?>:</b>
	<?php echo CHtml::encode($data->course_name_rus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_name_eng')); ?>:</b>
	<?php echo CHtml::encode($data->course_name_eng); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_tags_rus')); ?>:</b>
	<?php echo CHtml::encode($data->course_tags_rus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_tags_eng')); ?>:</b>
	<?php echo CHtml::encode($data->course_tags_eng); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('outcomes_rus')); ?>:</b>
	<?php echo CHtml::encode($data->outcomes_rus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('outcomes_eng')); ?>:</b>
	<?php echo CHtml::encode($data->outcomes_eng); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instructor_email')); ?>:</b>
	<?php echo CHtml::encode($data->instructor_email); ?>
	<br />

	*/ ?>

</div>
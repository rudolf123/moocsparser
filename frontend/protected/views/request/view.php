<h1>Просмотр курса №<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'instructor_name_rus',
		'instructor_name_eng',
		'course_name_rus',
		'course_name_eng',
		'course_tags_rus',
		'course_tags_eng',
		'outcomes_rus',
		'outcomes_eng',
		'date',
		'instructor_email',
		'url',
	),
)); ?>

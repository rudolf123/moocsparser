<h1>Просмотр курса №<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'schoolname',
		'platform',
		'start',
		'length',
		'estimate',
		'language',
		'subtitles',
		'about',
		'staff',
		'staff_profile',
		'info',
		'similar',
	),
)); ?>

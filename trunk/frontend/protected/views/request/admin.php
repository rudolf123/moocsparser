<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление курсами</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'request-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'instructor_name_rus',
		'instructor_name_eng',
		'course_name_rus',
		'course_name_eng',
		/*
		'course_tags_eng',
		'outcomes_rus',
		'outcomes_eng',
		'date',
		'instructor_email',
		'url',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
/* @var $this CoursesMoodleController */
/* @var $model CoursesMoodle */

$this->breadcrumbs=array(
	'Courses Moodles'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CoursesMoodle', 'url'=>array('index')),
	array('label'=>'Create CoursesMoodle', 'url'=>array('create')),
	array('label'=>'Update CoursesMoodle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoursesMoodle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CoursesMoodle', 'url'=>array('admin')),
);
?>

<h1>View CoursesMoodle #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'moodle_id',
		'url',
		'title',
	),
)); ?>

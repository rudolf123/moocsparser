<?php
/* @var $this CoursesMoodleController */
/* @var $model CoursesMoodle */

$this->breadcrumbs=array(
	'Courses Moodles'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CoursesMoodle', 'url'=>array('index')),
	array('label'=>'Create CoursesMoodle', 'url'=>array('create')),
	array('label'=>'View CoursesMoodle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CoursesMoodle', 'url'=>array('admin')),
);
?>

<h1>Update CoursesMoodle <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this CoursesMoodleController */
/* @var $model CoursesMoodle */

$this->breadcrumbs=array(
	'Courses Moodles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CoursesMoodle', 'url'=>array('index')),
	array('label'=>'Manage CoursesMoodle', 'url'=>array('admin')),
);
?>

<h1>Create CoursesMoodle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
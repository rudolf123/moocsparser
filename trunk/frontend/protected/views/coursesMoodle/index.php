<?php
/* @var $this CoursesMoodleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Courses Moodles',
);

$this->menu=array(
	array('label'=>'Create CoursesMoodle', 'url'=>array('create')),
	array('label'=>'Manage CoursesMoodle', 'url'=>array('admin')),
);
?>

<h1>Courses Moodles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

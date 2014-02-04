<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#question-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Список курсов</h3>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php/* $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'question-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'theme',
		'text',
		'image',
                'rate',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{update}{delete}',
                        'viewButtonUrl' => 'Yii::app()->createUrl("question/view", array("id"=>$data->id, "backurl"=>Yii::app()->request->url))',
                        'updateButtonUrl' => 'Yii::app()->createUrl("question/update", array("id"=>$data->id, "backurl"=>Yii::app()->request->url))',
                        'deleteButtonUrl'=> 'Yii::app()->createUrl("question/delete", array("id"=>$data->id))',
		),
	),
)); */?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'schoolname',
		'platform',
		'start',
		'length',
		'estimate',
		'language',
		/*'subtitles',
		'about',
		'staff',
		'staff_profile',
		'info',
		'similar',*/
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{update}{delete}',
                        'viewButtonUrl' => 'Yii::app()->createUrl("course/view", array("id"=>$data->id, "backurl"=>Yii::app()->request->url))',
                        'updateButtonUrl' => 'Yii::app()->createUrl("course/update", array("id"=>$data->id, "backurl"=>Yii::app()->request->url))',
                        'deleteButtonUrl'=> 'Yii::app()->createUrl("course/delete", array("id"=>$data->id))',
		),
	),
)); ?>

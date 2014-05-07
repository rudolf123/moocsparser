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

<div>
    <a href="<?php echo Yii::app()->createUrl('/request/export')?>" class="button">Экспортировать в Excel</a>
    <!--a href="<?php// echo Yii::app()->createUrl('/request/import')?>" class="button">Импортировать из Excel</a>-->
    <?php
//        $this->widget('application.extensions.xupload.XUpload', array(
//                            'url' => Yii::app()->createUrl("/request/admin"),
//                            'model' => $form,
//                            'attribute' => 'file',
//                            'multiple' => true,
//        ));
    ?>
    
    <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'fileform',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'enctype'=>'multipart/form-data',
                    'accept-charset'=>'UTF-8',
                    'onsubmit'=>"return validate()",
                ),
            )); ?>


            <?php echo CHtml::submitButton('Импортировать из Excel', array(
                                'class'=>'submit_button',
                                
              ));
            ?>
        <div class = "submit_file">
            <p id="fileName" style="width: 100%; height: 100%; position: absolute;">Выбрать файл</p>
            <?php echo CHtml::fileField('xls_file','',array('id'=>'file1', "style" => 'opacity: 0; position: absolute;  top: 0; left: 0; width: 100%; height: 100%;', 
                'onchange'=>"javascript: document.getElementById ('fileName').innerHTML = this.value"));
            ?>
        </div>
    <?php $this->endWidget(); ?>

</div>



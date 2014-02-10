<?php
/* @var $this RequestController */
/* @var $model Request */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
                'id' => 'addrequest-form',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'well',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('request/create'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'instructor_name_rus'); ?>
		<?php echo $form->textField($model,'instructor_name_rus',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'instructor_name_rus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instructor_name_eng'); ?>
		<?php echo $form->textField($model,'instructor_name_eng',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'instructor_name_eng'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_name_rus'); ?>
		<?php echo $form->textField($model,'course_name_rus',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'course_name_rus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_name_eng'); ?>
		<?php echo $form->textField($model,'course_name_eng',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'course_name_eng'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_tags_rus'); ?>
		<?php echo $form->textArea($model,'course_tags_rus',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'course_tags_rus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_tags_eng'); ?>
		<?php echo $form->textArea($model,'course_tags_eng',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'course_tags_eng'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'outcomes_rus'); ?>
		<?php echo $form->textArea($model,'outcomes_rus',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'outcomes_rus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'outcomes_eng'); ?>
		<?php echo $form->textArea($model,'outcomes_eng',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'outcomes_eng'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instructor_email'); ?>
		<?php echo $form->textField($model,'instructor_email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'instructor_email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
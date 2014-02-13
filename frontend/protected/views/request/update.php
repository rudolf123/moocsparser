<h1>Редактирование курса № <?php echo $model->id; ?></h1>

<div class="row">
<?php
$form = $model;
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'msform',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'accept-charset'=>'UTF-8',
                    'style'=>'width:100%; margin-top:0px; padding-bottom:0px'
                ),
            ));
?>
    <?php echo $forms->errorSummary($form); ?><br />
     <table cellspacing="0">
    <tr><th>Наименование поля</th><th>Русский язык</th><th>Английский язык</th></tr>
    <tr><td>ФИО</td><td> <?php echo $forms->textField($form, 'instructor_name_rus',array('placeholder' => 'ФИО преподавателя (рус.)')) ?> </td><td> <?php echo $forms->textField($form, 'instructor_name_eng',array('placeholder' => 'ФИО преподавателя (англ.)')) ?> </td></tr>
    <tr><td>Наименование курса</td><td> <?php echo $forms->textField($form, 'course_name_rus',array('placeholder' => 'Название курса (рус.)')) ?> </td><td> <?php echo $forms->textField($form, 'course_name_eng',array('placeholder' => 'Название курса  (англ.)')) ?> </td></tr>
    <tr><td>Ключевые слова, описывающие содержание курса</td><td> <?php echo $forms->textArea($form, 'course_tags_rus',array('placeholder' => 'Ключевые слова курса  (рус.)')) ?> </td><td><?php echo $forms->textArea($form, 'course_tags_eng',array('placeholder' => 'Ключевые слова курса  (англ.)')) ?>  </td></tr>
    <tr><td>Компетенции (Что умеет студент после окончания курса?)</td><td> <?php echo $forms->textArea($form, 'outcomes_rus',array('placeholder' => 'Компетенция (Что умеет студент после окончания курса (рус.)?)')) ?> </td><td> <?php echo $forms->textArea($form, 'outcomes_eng',array('placeholder' => 'Компетенция (Что умеет студент после окончания курса (англ.)?)')) ?> </td></tr>
    <tr><td>Дата заполнения</td><td>  </td><td>  </td></tr>

<?php// echo $forms->textField($form, 'url',array('placeholder' => 'Ссылка на курс в moodle')) ?>
<?php //echo $forms->textField($form, 'instructor_name_rus',array('placeholder' => 'ФИО преподавателя (рус.)')) ?>
<?php// echo $forms->textField($form, 'instructor_name_eng',array('placeholder' => 'ФИО преподавателя (англ.)')) ?>
<?php //echo $forms->textField($form, 'course_name_rus',array('placeholder' => 'Название курса (рус.)')) ?>
<?php //echo $forms->textField($form, 'course_name_eng',array('placeholder' => 'Название курса  (англ.)')) ?> 
<?php //echo $forms->textArea($form, 'course_tags_rus',array('placeholder' => 'Ключевые слова курса  (рус.)')) ?>
<?php// echo $forms->textArea($form, 'course_tags_eng',array('placeholder' => 'Ключевые слова курса  (англ.)')) ?>
<?php //echo $forms->textArea($form, 'outcomes_rus',array('placeholder' => 'Компетенция (Что умеет студент после окончания курса (рус.)?)')) ?>
<?php //echo $forms->textArea($form, 'outcomes_eng',array('placeholder' => 'Компетенция (Что умеет студент после окончания курса (англ.)?)')) ?>
<?php //echo $forms->textField($form, 'instructor_email',array('placeholder' => 'E-mail преподавателя для связи')) ?>
	</table>
    <br />
    <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            'htmlOptions'=>array(
                'class'=>'action-button'
                ),
            )
        );?>
<?php $this->endWidget(); ?>

</div>
<div id="content">
<h1>Регистрация нового курса</h1>

<?php>
        $forms = $this->beginWidget('CActiveForm', array(
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

            ));
?>
<?php echo $forms->errorSummary($form); ?><br />
    <table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
         <tr>
            
            <td width="150"><?php echo $forms->labelEx($form, 'instructor_name_rus'); ?></td>
            <td><?php echo $forms->textField($form, 'instructor_name_rus') ?></td>
         </tr>
        <tr>
            
            <td><?php echo $forms->labelEx($form, 'instructor_name_eng'); ?></td>
            <td><?php echo $forms->textField($form, 'instructor_name_eng') ?></td>
         </tr>
         <tr>
            
            <td><?php echo $forms->labelEx($form, 'course_name_rus'); ?></td>
            <td><?php echo $forms->textField($form, 'course_name_rus') ?></td>
         </tr>
        <tr>
            
            <td><?php echo $forms->labelEx($form, 'course_name_eng'); ?></td>
            <td><?php echo $forms->textField($form, 'course_name_eng') ?></td>
         </tr>
         <tr>
            <td><?php echo $forms->labelEx($form, 'course_tags_rus'); ?></td>
            <td><?php echo $forms->textArea($form, 'course_tags_rus') ?></td>
         </tr>
         <tr>
            <td><?php echo $forms->labelEx($form, 'course_tags_eng'); ?></td>
            <td><?php echo $forms->textArea($form, 'course_tags_eng') ?></td>
         </tr>
        <tr>
            <td><?php echo $forms->labelEx($form, 'outcomes_rus'); ?></td>
            <td><?php echo $forms->textArea($form, 'outcomes_rus') ?></td>
         </tr>
        <tr>
            <td><?php echo $forms->labelEx($form, 'outcomes_eng'); ?></td>
            <td><?php echo $forms->textArea($form, 'outcomes_eng') ?></td>
         </tr>
        <tr>
            <td><?php echo $forms->labelEx($form, 'instructor_email'); ?></td>
            <td><?php echo $forms->textField($form, 'instructor_email') ?></td>
         </tr>
        <tr>
            <td></td>
             <td>
                 <?php $this->widget('zii.widgets.jui.CJuiButton', array(
                            'name'=>'buttonSubmit',
                            'caption'=>'Сохранить',
                            //'value'=>'abc',
                            'htmlOptions'=>array(
                                'style'=>'height:40px; width:215px; margin-top: 10px; margin-bottom: 10px ',
                                'class'=>'ui-button-primary'
                                ),
                            'onclick'=>'submit',
                            )
                        ); ?>
             </td>
        </tr>
    </table>

<!-- Закрываем форму !-->
        <?php $this->endWidget(); ?>

</div>
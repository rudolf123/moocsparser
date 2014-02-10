<div id="content">
<h1>Регистрация</h1>

<?php>
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'adduser-form',
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
                'action' => array('user/registration'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
?>
<?php echo $forms->errorSummary($form); ?><br />
    <table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
         <tr>
            <!-- Выводим поле для фамилии !-->
            <td width="150"><?php echo $forms->labelEx($form, 'surname'); ?></td>
            <td><?php echo $forms->textField($form, 'surname') ?></td>
         </tr>
        <tr>
            <!-- Выводим поле для имени !-->
            <td><?php echo $forms->labelEx($form, 'name'); ?></td>
            <td><?php echo $forms->textField($form, 'name') ?></td>
         </tr>
         <tr>
            <!-- Выводим поле для отчества !-->
            <td><?php echo $forms->labelEx($form, 'secondname'); ?></td>
            <td><?php echo $forms->textField($form, 'secondname') ?></td>
         </tr>
        <tr>
            <!-- Выводим поле для логина !-->
            <td><?php echo $forms->labelEx($form, 'login'); ?></td>
            <td><?php echo $forms->textField($form, 'login') ?></td>
            <td><?php echo $forms->error($form,'login'); ?></td>
         </tr>
         <!-- Выводим поле для пароля !-->
         <tr>
            <td><?php echo $forms->labelEx($form, 'passwd'); ?></td>
            <td><?php echo $forms->passwordField($form, 'passwd') ?></td>
            <td><?php echo $forms->error($form,'passwd'); ?></td>
         </tr>
        <tr>
            <!-- Выводим поле для повтора пароля !-->
            <td><?php echo $forms->labelEx($form, 'passwd2'); ?></td>
            <td><?php echo $forms->passwordField($form, 'passwd2') ?></td>
            <td><?php echo $forms->error($form,'passwd2'); ?></td>
         </tr>
         
         <tr>
            <!-- Выводим поле для пароля преподавателя!-->
            <td><?php echo $forms->labelEx($form, 'passwdModerator'); ?></td>
            <td><?php echo $forms->passwordField($form, 'passwdModerator') ?></td>
         </tr>
        <tr>
            <td></td>
            <!-- Кнопка "регистрация" !-->
             <td>
                 <?php $this->widget('zii.widgets.jui.CJuiButton', array(
                            'name'=>'buttonSubmit',
                            'caption'=>'Зарегистрироваться',
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
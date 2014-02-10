<div id="content">
<h1>Авторизация</h1>

<?php>
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'loginForm',
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
                'action' => array('user/login'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
?>
<?php echo $forms->errorSummary($form); ?><br />
    <table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
        <tr>
            <td width="150"><?php echo $forms->labelEx($form, 'login'); ?></td>
             <td><?php echo $forms->textField($form, 'login') ?></td>
        </tr>
        <tr>
            <td><?php echo $forms->labelEx($form, 'passwd'); ?></td>
             <td><?php echo $forms->passwordField($form, 'passwd') ?></td>
        <tr>
        <tr>
            <td></td>
            <td><?php $this->widget('zii.widgets.jui.CJuiButton', array(
                            'name'=>'buttonAddFolder',
                            'caption'=>'Войти',
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

<?php $this->endWidget(); ?>
</div>
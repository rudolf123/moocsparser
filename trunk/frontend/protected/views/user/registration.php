<div class="row">
    <h1>Регистрация</h1>

    <?php
    $forms = $this->beginWidget('CActiveForm', array(
        'id' => 'msform',
        'enableClientValidation' => true,
        //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        ),
        'htmlOptions' => array(
            'class' => 'well',
            'accept-charset' => 'UTF-8',
        ),
        'action' => array('user/registration'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')
    ));
    ?>
    <?php echo $forms->errorSummary($form); ?><br />
    <fieldset>
        <?php echo $forms->error($form, 'surname'); ?>
        <?php echo $forms->labelEx($form, 'surname'); ?>
        <?php echo $forms->textField($form, 'surname') ?>
        <?php echo $forms->error($form, 'name'); ?>
        <?php echo $forms->labelEx($form, 'name'); ?>
        <?php echo $forms->textField($form, 'name') ?>
        <?php echo $forms->labelEx($form, 'secondname'); ?>
        <?php echo $forms->textField($form, 'secondname') ?>
        <?php echo $forms->error($form, 'email'); ?>
        <?php echo $forms->labelEx($form, 'email'); ?>
        <?php echo $forms->textField($form, 'email') ?>
        <?php echo $forms->error($form, 'login'); ?>
        <?php echo $forms->labelEx($form, 'login'); ?>
        <?php echo $forms->textField($form, 'login') ?>
        <?php echo $forms->error($form, 'passwd'); ?>
        <?php echo $forms->labelEx($form, 'passwd'); ?>
        <?php echo $forms->passwordField($form, 'passwd') ?>
        <?php echo $forms->error($form, 'passwd2'); ?>
        <?php echo $forms->labelEx($form, 'passwd2'); ?>
        <?php echo $forms->passwordField($form, 'passwd2') ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name' => 'buttonSubmit',
            'caption' => 'Зарегистрироваться',
            'htmlOptions' => array(
                'style' => 'height:40px; width:215px; margin-top: 10px; margin-bottom: 10px ',
                'class' => 'action-button'
            ),
            'onclick' => 'submit',
                )
        );
        ?>
    </fieldset>

    <!-- Закрываем форму !-->
    <?php $this->endWidget(); ?>

</div>
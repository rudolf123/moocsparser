<div class="row">
    <h1>Авторизация</h1>

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
            'accept-charset' => 'UTF-8',
        ),
        'action' => array('user/login'),
    ));
    ?>

    <?php echo $forms->errorSummary($form); ?><br />
    <fieldset>
        <?php echo $forms->textField($form, 'login', array('placeholder' => 'Имя пользователя')) ?>
        <?php echo $forms->passwordField($form, 'passwd', array('placeholder' => 'Пароль')) ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name' => 'submit',
            'caption' => 'Войти',
            'htmlOptions' => array(
                'class' => 'action-button'
            ),
            'onclick' => 'submit',
                )
        );
        ?>
        <br />
        <?php echo CHtml::link('Регистрация нового пользователя', array('user/registration')); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
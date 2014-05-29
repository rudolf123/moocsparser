<div class="row">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'msform',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'accept-charset' => 'UTF-8',
            'style' => 'width:100%; margin-top:0px; padding-bottom:0px'
        ),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>

        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>



        <?php echo $form->labelEx($model, 'schoolname'); ?>
        <?php echo $form->textField($model, 'schoolname', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'schoolname'); ?>



        <?php echo $form->labelEx($model, 'platform'); ?>
        <?php echo $form->textField($model, 'platform', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'platform'); ?>



        <?php echo $form->labelEx($model, 'start'); ?>
        <?php echo $form->textField($model, 'start', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'start'); ?>



        <?php echo $form->labelEx($model, 'length'); ?>
        <?php echo $form->textField($model, 'length', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'length'); ?>



        <?php echo $form->labelEx($model, 'estimate'); ?>
        <?php echo $form->textField($model, 'estimate', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'estimate'); ?>



        <?php echo $form->labelEx($model, 'language'); ?>
        <?php echo $form->textField($model, 'language', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'language'); ?>



        <?php echo $form->labelEx($model, 'subtitles'); ?>
        <?php echo $form->textField($model, 'subtitles', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'subtitles'); ?>



        <?php echo $form->labelEx($model, 'about'); ?>
        <?php echo $form->textArea($model, 'about', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'about'); ?>



        <?php echo $form->labelEx($model, 'staff'); ?>
        <?php echo $form->textArea($model, 'staff', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'staff'); ?>



        <?php echo $form->labelEx($model, 'staff_profile'); ?>
        <?php echo $form->textArea($model, 'staff_profile', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'staff_profile'); ?>



        <?php echo $form->labelEx($model, 'info'); ?>
        <?php echo $form->textArea($model, 'info', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'info'); ?>

        <?php echo $form->labelEx($model, 'similar'); ?>
        <?php echo $form->textArea($model, 'similar', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'similar'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name' => 'submit',
            'caption' => 'Сохранить',
            'htmlOptions' => array(
                'class' => 'action-button'
            ),
            'onclick' => 'submit',
                )
        );
        ?>
    </fieldset>

    <?php $this->endWidget(); ?>

</div><!-- form -->
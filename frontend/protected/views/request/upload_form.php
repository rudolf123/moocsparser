<?php $form=$this->beginWidget('CActiveForm', array(
                'id' => 'addfolder-form',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'enctype'=>'multipart/form-data',
                    'accept-charset'=>'UTF-8',
                ),
            )); ?>
        <div class="row">
                <?php echo $form->labelEx($model,'img'); ?>
                <?php echo $form->fileField($model,'imgfile'); ?>
                <?php echo $form->error($model,'imgfile'); ?>
        </div>

        <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            //'value'=>'abc',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px;',
                'class'=>'ui-button-primary'
                ),
            )
        );?>              
    </div>


<?php $this->endWidget(); ?>

<div id="content">
<?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs',
        'tabs'=>array(
                array('label'=>'Информация', 'content'=>$this->renderPartial('profileView',array('model' => $model),true), 'active'=>true),
                array('label'=>'Изменить данные', 'content'=>$this->renderPartial('profileUpdate',array('model' => $model),true)),
            ),
        ));
?>
</div>

<script>
        $(document).ready(function(){
            function timer()
            {
                $.ajax({
                        type: "POST",
                        url:    "<? echo Yii::app()->createUrl('helptree/keepAliveStatus'); ?>",
                        data:  {val1:1,val2:2},
                        success: function(){
                             //alert("Sucess");
                            },
                        error: function(){
                        //alert("failure");

                        }
                      });
            }
            setInterval(timer,60000);
        });
</script>
<h1>Новые заявки</h1>
<?php
Yii::app()->clientScript->registerScript('ajaxupdate_add', "
$('#userrequest-grid a.ajaxupdate_add').live('click', function() {
        $.fn.yiiGridView.update('userrequest-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function() {
                        $.fn.yiiGridView.update('userrequest-grid');
                }
        });
        return false;
});
");


Yii::app()->clientScript->registerScript('ajaxupdate_rem', "
$('#userrequest-grid a.ajaxupdate_rem').live('click', function() {
        $.fn.yiiGridView.update('userrequest-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function() {
                        $.fn.yiiGridView.update('userrequest-grid');
                }
        });
        return false;
});
");

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'userrequest-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'surname',
        'name',
        'secondname',
        'email',
        'regdate',
        array(
            'name' => '',
            'type' => 'raw',
            'value' => 'Chtml::link(CHtml::image("' . Yii::app()->request->baseUrl . '/assets/plus.png","Принять",array("title"=>"Принять")),
                                      array("ajaxUpdateRequestStatus", "add_uid"=>$data->id), array("class"=>"ajaxupdate_add"))',
        ),
        array(
            'name' => '',
            'type' => 'raw',
            'value' => 'Chtml::link(CHtml::image("' . Yii::app()->request->baseUrl . '/assets/minus.png","Отклонить",array("title"=>"Отклонить")),
                                      array("ajaxUpdateRequestStatus", "rem_uid"=>$data->id), array("class"=>"ajaxupdate_rem"))',
        ),
    ),
));
?>

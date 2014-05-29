<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список курсов ПензГТУ(Moodle)</h1>

<?php //echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->

<?php
/* if (Yii::app()->user->checkAccess('administrator') || Yii::app()->user->checkAccess('moderator')) {
  $this->widget('zii.widgets.grid.CGridView', array(
  'id' => 'request-grid',
  'dataProvider' => $model->search(),
  'filter' => $model,
  'columns' => array(
  'id',
  'course_name_rus',
  'instructor_name_rus',
  'course_tags_rus',
  array(
  'name' => 'url',
  'type' => 'raw',
  'value' => ' CHtml::link($data->url, CHtml::normalizeUrl($data->url))',
  ),
  array('class' => 'CButtonColumn'),
  ),
  ));
  } else { */
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'request-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'course_name_rus',
        'instructor_name_rus',
        'course_tags_rus',
        array(
            'name' => 'url',
            'type' => 'raw',
            'value' => ' CHtml::link($data->url, CHtml::normalizeUrl($data->url))',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'viewButtonUrl' => 'Yii::app()->createUrl("request/view", array("id"=>$data->id, "backurl"=>Yii::app()->request->url))',
            'updateButtonUrl' => 'Yii::app()->createUrl("request/update", array("id"=>$data->id, "backurl"=>Yii::app()->request->url))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("request/delete", array("id"=>$data->id))',
        ),
    ),
));
//}
?>

<?php
if (Yii::app()->user->checkAccess('user')) {
    echo '<a href=' . Yii::app()->createUrl("/request/create") . ' class="button">Зарегистрировать новый курс</a>';
};
if (Yii::app()->user->checkAccess('administrator') || Yii::app()->user->checkAccess('moderator')) {
    echo '<a href=' . Yii::app()->createUrl('/request/export') . ' class="button" style="margin-left:5px">Экспортировать в Excel</a>';
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'fileform',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'accept-charset' => 'UTF-8',
            'onsubmit' => "return validate()",
        ),
    ));
    echo CHtml::submitButton('Импортировать из Excel', array(
        'class' => 'submit_button',
    ));
    echo '<div class = "submit_file">
    <p id="fileName" style="width: 100%; height: 100%; position: absolute;">Выбрать файл</p>';
    echo CHtml::fileField('xls_file', '', array('id' => 'file1', "style" => 'opacity: 0; position: absolute;  top: 0; left: 0; width: 100%; height: 100%;',
        'onchange' => "javascript: document.getElementById ('fileName').innerHTML = this.value"));
    $this->endWidget();
}
?>

</div>

<script type="text/javascript">
    function validate() {
        valid = true;
        if ($("#file1").val() == '') {
            valid = false;
            alert('Выберите файл для импорта!');
        }
        return valid
    }
</script>
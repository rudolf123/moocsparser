<div class="row">
<h1>Регистрация нового курса</h1>

<?php
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'msform',
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
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active_step">Общая информация</li>
		<li>Описание курса</li>
		<li>E-mail</li>
	</ul>
        
<?php echo $forms->errorSummary($form); ?><br />
	<!-- fieldsets -->
	<fieldset>
		<h2 class="fs-title">Общая информация</h2>
		<h3 class="fs-subtitle">Шаг 1</h3>
                <?php echo $forms->textField($form, 'url',array('placeholder' => 'Ссылка на курс в moodle')) ?>
                <?php echo $forms->textField($form, 'instructor_name_rus',array('placeholder' => 'ФИО преподавателя (рус.)')) ?>
                <?php echo $forms->textField($form, 'instructor_name_eng',array('placeholder' => 'ФИО преподавателя (англ.)')) ?>
                <?php echo $forms->textField($form, 'course_name_rus',array('placeholder' => 'Название курса (рус.)')) ?>
                <?php echo $forms->textField($form, 'course_name_eng',array('placeholder' => 'Название курса  (англ.)')) ?> 
                <input type="button" name="next" class="next action-button" value="Далее" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Описание курса</h2>
		<h3 class="fs-subtitle">Шаг 2</h3>
                <?php echo $forms->textArea($form, 'course_tags_rus',array('placeholder' => 'Ключевые слова курса  (рус.)')) ?>
                <?php echo $forms->textArea($form, 'course_tags_eng',array('placeholder' => 'Ключевые слова курса  (англ.)')) ?>
                <?php echo $forms->textArea($form, 'outcomes_rus',array('placeholder' => 'Компетенция (Что умеет студент после окончания курса (рус.)?)')) ?>
                <?php echo $forms->textArea($form, 'outcomes_eng',array('placeholder' => 'Компетенция (Что умеет студент после окончания курса (англ.)?)')) ?>
                <input type="button" name="next" class="next action-button" value="Далее" />
                <input type="button" name="previous" class="previous action-button" value="Назад" />
        </fieldset>
        <fieldset>
                <h2 class="fs-title">E-mail</h2>
		<h3 class="fs-subtitle">Шаг 3</h3>
                <?php echo $forms->textField($form, 'instructor_email',array('placeholder' => 'E-mail преподавателя для связи')) ?>
                <input type="button" name="previous" class="previous action-button" value="Назад" />
		
	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            'htmlOptions'=>array(
                'class'=>'action-button'
                ),
            )
        );?>
        </fieldset>


<!-- Закрываем форму !-->
        <?php $this->endWidget(); ?>

</div>

<script src="http://thecodeplayer.com/uploads/js/jquery-1.9.1.min.js" type="text/javascript"></script>

<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>

<script type="text/javascript">
    
function SendPost() {
    $.ajax({
             type:'post',//тип запроса: get,post либо head
             //url:'http://moocstable/index.php/request/create',//url адрес файла обработчика
             url: '<?php echo Yii::app()->request->hostInfo.Yii::app()->request->url ?>',
             data:{'url':document.getElementById('Request_url').value},//параметры запроса
             response:'text',//тип возвращаемого ответа text либо xml
             success: function(data)
             {
               $("#Request_course_name_rus").val(data);
             }
         });
}
(function($){
       
    $.fn.onInput = function(callBack) {
               
        var fields = this;
       
        fields.focus(function(e) {
               
                var field = $(this);
               
                $(this).data('value', $.trim($(this).val()));
               
                $(this).data('timerChange', setInterval(function(){
                       
                        if($.trim(field.val()) != field.data('value'))
                        {
                                field.trigger('onInput');
                                field.data('value', $.trim(field.val()));
                        }
                       
                }, 30));
        });
       
        fields.blur(function(e) {
               
                clearInterval($(this).data('timerChange'));
               
                if($.trim($(this).val()) != $(this).data('value'))
                {
                        $(this).trigger('onInput');
                        $(this).data('value', $.trim($(this).val()));
                }
        });
       
        fields.on('onInput', function(e){
                if(typeof(callBack) == 'function')
                callBack.call(this, e);
        });    
 
        return fields;
   };
 
})(jQuery);

    $('#Request_url:text').onInput(function(){
                    SendPost();  
    });
</script>

<script>
    //jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active_step");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active_step");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})
</script>

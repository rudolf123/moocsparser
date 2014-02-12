<?php

class RequestController extends Controller
{
    public function actionIndex()
    {
        $this->render("index");
    }
    
    public function actionCreate()
    {
        if(isset($_POST['url'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	    $moodlecourse = CoursesMoodle::model()->findByAttributes(array('url'=>$_POST['url']));
            if ($moodlecourse)
                echo $moodlecourse->title;
            else
                echo "Курс не найден, введите название вручную";
            
            Yii::app()->end();
	}
        
        $form = new Request();

        if (!empty($_POST['Request'])) {
            $form->attributes = $_POST['Request'];
            $form->course_tags_eng = $_POST['course_tags_eng'];
            $form->outcomes_eng = $_POST['outcomes_eng'];
            $form->date = date('Y-m-d H:i:s', time());;
            if ($form->save())
            {
                    $this->render("success");
                    Yii::app()->end();
            }
        }

        $this->render("create", array('form'=>$form));
    }
}
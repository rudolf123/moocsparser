<?php

class RequestController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'xupload.actions.XUploadAction',
                'path' => Yii::app()->getBasePath() . "/../uploads",
                'publicPath' => Yii::app()->getBaseUrl() . "/uploads",
            ),
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
           array('allow', // allow authenticated user
                'actions' => array('view', 'admin', 'create'),
                'users' => array('@',),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('import', 'export'),
                'expression' => array('Controller', 'allowOnlyAdminModer')
            ),
            array('allow', // allow only the owner to perform 'view' 'update' 'delete' actions
                'actions' => array('create', 'admin', 'view', 'update', 'delete',),
                'expression' => array('Controller', 'allowOnlyOwner')
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render("index");
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (isset($_POST['url'])) {
            header("Content-type: text/txt; charset=UTF-8");
            $moodlecourse = CoursesMoodle::model()->findByAttributes(array('url' => $_POST['url']));
            if ($moodlecourse)
                echo $moodlecourse->title;
            else
                echo "Курс не найден, введите название вручную";

            Yii::app()->end();
        }

        $form = new Request();

        if (!empty($_POST['Request'])) {
            $form->attributes = $_POST['Request'];
            //$form->course_tags_eng = $_POST['course_tags_eng'];
            //$form->outcomes_eng = $_POST['outcomes_eng'];
            $form->date = date('Y-m-d H:i:s', time());
            $form->creator_id = Yii::app()->user->id;
            if ($form->save()) {
                $this->render("success");
                Yii::app()->end();
            }
        }
        $user = User::model()->findByAttributes(array('id' => Yii::app()->user->id));

        $this->render("create", array('form' => $form, 'user' => $user));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Request'])) {
            $model->attributes = $_POST['Request'];
            if ($model->save())
                $this->redirect('../admin');
            //$this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Request('search');
        $model->unsetAttributes();  // clear any default values

        if ($_FILES) {
            $temp = CUploadedFile::getInstanceByName("xls_file");  // gets me the file into this varible (  i gues this wont work for multiple files at the same time )
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/uploads/')) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/', 0777);
            }
            $temp->saveAs($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $temp->name);

            Yii::import('ext.phpexcelreader.JPhpExcelReader');
            $data = new JPhpExcelReader($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $temp->name);
            //if ($data)
            {
                $user = Yii::app()->db->createCommand()->truncateTable('requests');
                //$user->execute();
            }
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                // check if item number is empty
                if (empty($data->sheets[0]['cells'][$i][1]))
                    continue; {
                    $model = new Request();
                    $model->id = $data->sheets[0]['cells'][$i][1];
                    $model->instructor_name_rus = $data->sheets[0]['cells'][$i][2];
                    $model->instructor_name_eng = $data->sheets[0]['cells'][$i][3];
                    $model->course_name_rus = $data->sheets[0]['cells'][$i][4];
                    $model->course_name_eng = $data->sheets[0]['cells'][$i][5];
                    $model->course_tags_rus = $data->sheets[0]['cells'][$i][6];
                    $model->course_tags_eng = $data->sheets[0]['cells'][$i][7];
                    $model->outcomes_rus = $data->sheets[0]['cells'][$i][8];
                    $model->outcomes_eng = $data->sheets[0]['cells'][$i][9];
                    $model->date = $data->sheets[0]['cells'][$i][10];
                    $model->instructor_email = $data->sheets[0]['cells'][$i][11];
                    $model->url = $data->sheets[0]['cells'][$i][12];
                    $model->creator_id = $data->sheets[0]['cells'][$i][13];

                    $model->save();
                }
            }
            $this->redirect('admin');
        }

        //echo $data->dump(true,true);
//                if(isset($_POST['XUploadForm']))
//                {
//                    if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads/'))
//                    {
//                        mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/', 0777);
//                    };
//
//                    $rnd = rand(0, 9999);
//                        // generate random number between 0-9999
//                    $uploadedFile = CUploadedFile::getInstance($form, 'file');
//                    $fileName = "{$rnd}-{$uploadedFile}";
//                    $uploadedFile -> saveAs($_SERVER['DOCUMENT_ROOT'].'/uploads/' . $fileName);
//                    chmod( $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $fileName, 0777 );
//                    Yii::import('ext.phpexcelreader.JPhpExcelReader');
//                    $data=new JPhpExcelReader($_SERVER['DOCUMENT_ROOT'].'/uploads/' . $fileName);
//                    echo $data->dump(true,true);
//                }
        if (isset($_GET['Request']))
            $model->attributes = $_GET['Request'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionRunJavaUpdate() {
        echo "234";
        shell_exec('java -jar ' . $_SERVER['DOCUMENT_ROOT'] . '/uploads/moocsparser.jar');
        exec('java -jar ' . $_SERVER['DOCUMENT_ROOT'] . '/uploads/moocsparser.jar', $returnCode);
        echo $returnCode;
    }

    public function actionExport() {
        $models = Request::model()->findAll();
        $data = array(
            1 => array('#', 'ФИО преподавателя (рус.)', 'ФИО преподавателя (англ.)', 'Наименование курса (рус.)', 'Наименование курса (англ.)',
                'Ключевые слова курса (рус.)', 'Ключевые слова курса (англ.)', 'Компетенции(что умеет студент после окончания курса)(рус.)', 'Компетенции(что умеет студент после окончания курса)(англ.)',
                'Дата заполнения', 'email преподавателя для связи', 'Ссылка на курс в системе moodle', 'ID Владельца')
        );
        foreach ($models as $model)
            array_push($data, $model);
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
        $xls->addArray($data);
        $xls->generateXML('MoodleCoursesExport');
    }

    public function actionImport() {
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $data = new JPhpExcelReader('example.xls');
        echo $data->dump(true, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Request::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'msform') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

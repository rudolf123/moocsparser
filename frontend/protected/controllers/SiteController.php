<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', 
                'actions' => array('login', 'registration', 'index','error'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user
                'actions' => array('logout'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->redirect(Yii::app()->createUrl("user/login"));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $this->redirect(Yii::app()->createUrl("user/logout"));
    }

    public function actionAdminUserRequests() {
        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => array(
                'condition' => 'approved = 0',
            ),
        ));
        $this->render('adminUserRequests', array('dataProvider' => $dataProvider));
    }

    public function actionAjaxUpdateRequestStatus() {
        if (isset($_GET['add_uid'])) {
            $model = User::model()->findByPk($_GET['add_uid']);
            $model->approved = 1;
            $model->save();
            $this->sendEmailNotification($model->email, 'Ваша заявка была одобрена. Вы можете войти в систему под своими реквизитами');
            $dataProvider = new CActiveDataProvider('User', array(
                'criteria' => array(
                    'condition' => 'approved = 0',
                ),
            ));
        }

        if (isset($_GET['rem_uid'])) {
            $model = User::model()->findByPk($_GET['rem_uid']);
            $email = $model->email;
            $model->delete();
            $modelAdmin = User::model()->find('login=:_login', array(':_login' => 'admin'));
            $this->sendEmailNotification($email, 'Ваша заявка не одобрена. Вы можете обратиться к администратору по адресу ' . $modelAdmin->email);
            $dataProvider = new CActiveDataProvider('User', array(
                'criteria' => array(
                    'condition' => 'approved = 0',
                ),
            ));
        }
    }

    private function sendEmailNotification($email, $data) {
        $subject = 'Регистрация в системе MoocsPenzGTU';
        $msg = $data;
        $b_name = 'MoocsPenzGTU';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $b_name . "\r\n";
        $mail = mail($email, $subject, $msg, $headers);
    }

    public function log($msg) {
        $file = fopen('log.txt', 'a');
        fwrite($file, $msg);
        fclose($file);
    }

}

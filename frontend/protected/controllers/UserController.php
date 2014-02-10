<?php
/**
 * UserController
 * 
 * Контроллер для наших пользователей. Содержит в себе следующие функции:
 * - авторизация
 * - регистрация
 * - выход
 * - редактирование профиля [в будущем]
  * 
 * @version 1.0
 *
 */
class UserController extends CController
{       
    public function actions()
    {
        return array(
            // Создаем экшинс captcha.
            // Он понадобиться нам для формы регистрации (да и авторизации)
             'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=> 0x003300,
                'maxLength'=> 3,
                'minLength'=> 3,
                'foreColor'=> 0x66FF66,
            ),
        );
    }
    
    /**
     * Метод входа на сайт
     * 
     * Метод в котором мы выводим форму авторизации
     * и обрабатываем её на правильность.
      */
    public function actionLogin()
    {
        $form = new User();
        // Проверяем является ли пользователь гостем
        // ведь если он уже зарегистрирован - формы он не должен увидеть.
        if (!Yii::app()->user->isGuest) {
            throw new CException('Вы уже зарегистрированы!');
         } else {
            if (!empty($_POST['User'])) {
                $form->attributes = $_POST['User'];
                    $form->scenario = 'login';
                    // Проверяем правильность данных
                    if($form->validate('login')) {
                        // если всё ок - кидаем на главную страницу
                        $model = User::model()->findByAttributes(array('login'=>$form->login));
                        $model->sessionend = date('Y-m-d H:i:s', time());
                        $model->online = true;
                        $model->save();
                        $this->redirect(Yii::app()->homeUrl);
                     } 

            } 
            $this->render('login', array('form' => $form));
        }
    }    
    
    /**
     * Метод выхода с сайта
     * 
     * Данный метод описывает в себе выход пользователя с сайта
     * Т.е. кнопочка "выход"
      */
    public function actionLogout()
    {
        $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
        $res = (strtotime(date('Y-m-d H:i:s', time())) - strtotime($model->sessionend));// strtotime($model->sessionstart));
        $model->sessionend = date('Y-m-d H:i:s', time());
        $model->learningtime = $model->learningtime + $res;
        $model->online = false;
        $model->save();
        
                // Выходим
        Yii::app()->user->logout();

        
        // Перезагружаем страницу
        $this->redirect(Yii::app()->user->returnUrl);
    }
    
    public function actionProfile()
    {
        $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
        //$allusers = User::model()->findAll();
        $this->render('profile', array('model' => $model));
    }
    
    public function actionUpdate()
    {
        $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
        
        $this->performAjaxValidation($model);
        if (!empty($_POST['User'])) {
            $pass = $model->passwd;
            $model->attributes = $_POST['User'];
            if ($model->passwd!==$pass)
                $model->passwd = crypt($model->passwd,'Fghqwe$trteysdf');//self::blowfishSalt());
            $model->save();            
        }
        
        $this->redirect(Yii::app()->createUrl('user/profile'));
    }
    
     /**
     * Метод регистрации
     *
     * Выводим форму для регистрации пользователя и проверяем
     * данные которые придут от неё.
      */
    public function actionRegistration()
    {
        $form = new User();

        // Проверяем являеться ли пользователь гостем
        // ведь если он уже зарегистрирован - формы он не должен увидеть.
        if (!Yii::app()->user->isGuest) {
             throw new CException('Вы уже зарегистрированны!');
        } else {
            // Если $_POST['User'] не пустой массив - значит была отправлена форма
            // следовательно нам надо заполнить $form этими данными
             // и провести валидацию. Если валидация пройдет успешно - пользователь
            // будет зарегистрирован, не успешно - покажем ошибку на экран
            $this->performAjaxValidation($form);
            
            if (!empty($_POST['User'])) {
                $form->setScenario('registration');
                 // Заполняем $form данными которые пришли с формы
                $form->attributes = $_POST['User'];
                $form->passwdModerator = $_POST['User']['passwdModerator'];
                // Запоминаем данные которые пользователь ввёл в капче
                // $form->verifyCode = $_POST['User']['verifyCode'];
                $form->passwd2 = $_POST['User']['passwd2'];
                
                    // В validate мы передаем название сценария. Оно нам может понадобиться
                    // когда будем заниматься созданием правил валидации [читайте дальше]
                     if($form->validate()) {
                        // Если валидация прошла успешно...
                        // Тогда проверяем свободен ли указанный логин..
                            $form->setScenario('');
                            if ($form->model()->count("login = :login", array(':login' => $form->login))) {
                                 // Указанный логин уже занят. Создаем ошибку и передаем в форму
                                $form->addError('login', 'Логин уже занят');
                                $this->render("registration", array('form' => $form));
                             } else {
                                // Выводим страницу что "все окей"
                                $form->passwd = crypt($form->passwd,'Fghqwe$trteysdf');//self::blowfishSalt());

                                $form->regdate = date('Y-m-d H:i:s', time());;
                                if ($form->passwdModerator==='tank')
                                    $form->role = 'moderator';
                                else 
                                    $form->role = 'user';
                                
                                if ($form->save())
                                    $this->render("registration_ok");
                            }
                                             
                    } else {
                        $this->render("registration", array('form' => $form));
                    }
             } else {
                // Если $_POST['User'] пустой массив - значит форму некто не отправлял.
                // Это значит что пользователь просто вошел на страницу регистрации
                // и ему мы должны просто показать форму.
                 
                $this->render("registration", array('form' => $form));
            }
        }
    }
    
    public function actionSaveChanges($id)
    {
        
    }
            
    function blowfishSalt($cost = 13)
    {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception("cost parameter must be between 4 and 31");
        }
        $rand = array();
        for ($i = 0; $i < 8; $i += 1) {
            $rand[] = pack('S', mt_rand(0, 0xffff));
        }
        $rand[] = substr(microtime(), 2, 6);
        $rand = sha1(implode('', $rand), true);
        $salt = '$2a$' . sprintf('%02d', $cost) . '$';
        $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
        return $salt;
    }
    function get_time_difference( $start, $end )
    {
        $uts['start']      =    strtotime( $start );
        $uts['end']        =    strtotime( $end );
        if( $uts['start']!==-1 && $uts['end']!==-1 )
        {
            if( $uts['end'] >= $uts['start'] )
            {
                $diff    =    $uts['end'] - $uts['start'];
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );            
                return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
            }
            else
            {
                trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
            }
        }
        else
        {
            trigger_error( "Invalid date/time data detected", E_USER_WARNING );
        }
        return( false );
    }
    
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='adduser-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }
} 
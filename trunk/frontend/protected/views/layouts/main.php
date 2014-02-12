<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/form.css" />-->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700" rel="stylesheet" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/config.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/skel.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/skel-panels.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/inputlistener.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/skel-noscript.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style-desktop.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="header-wrapper">
    <header class="container" id="site-header">
        <div class="row">
            <div class="12u">
                <div id="logo">
                    <h1>MoocsPenzGTU</h1>
                </div>
                <div id="mainmenu">
                    <nav id="nav">
                        <?php $this->widget('zii.widgets.CMenu',array(
                                'activeCssClass'=>'current_page_item',
                                'items'=>array(
                                        array('label'=>'Главная', 'url'=>array('/site/index')),
                                        array('label'=>'Курсы', 'url'=>array('/course/admin')),
                                        //array('label'=>'О проекте', 'url'=>array('/site/page', 'view'=>'about')),
                                        //array('label'=>'Обратная связь', 'url'=>array('/site/contact')),
                                        array('label'=>'Заявка на регистрацию курса', 'url'=>array('/request/create')),
                                        array('label'=>'Регистрация', 'url'=>array('user/registration'), 'visible'=>Yii::app()->user->isGuest),
                                        array('label'=>'Вход', 'url'=>array('user/login'), 'visible'=>Yii::app()->user->isGuest),
                                        array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                                ),
                        )); ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>
<!-- Main -->

<div id="main-wrapper">
        <div class="container">
            <?php echo $content; ?>
        </div>
</div>
	<div class="clear"></div>

        <div id="footer-wrapper">
                <footer class="container" id="site-footer">
                    <div class="row">
                        <div class="3u">
                            Copyright &copy; <?php echo date('Y'); ?> by Vladimir Yuranov (rudolf123@narod.ru).<br/>
                            All Rights Reserved.<br/>
                            <?php echo Yii::powered(); ?>
                        </div>
                    </div>
                </footer>
        </div><!-- footer -->

</div><!-- page -->

</body>
</html>

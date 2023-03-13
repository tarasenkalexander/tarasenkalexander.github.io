<?php
ini_set('opcache.enable', '0');

ob_start();
//session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');


include_once 'includes/config.php';

$mysqli = new mysqli($location, $username, $password, $database);
$mysqli->set_charset("utf8");

include_once $root . 'classes/session.class.php';
include_once $root . 'classes/lang.class.php';

$session = new session($mysqli);
$lang = new lang;

// functions

?>
<!DOCTYPE html>
<html>
    <head>
        <title>E-padruchnik</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="author" content="Suvit Aliaksandr | Сувит Александр">
	<meta name="description" content="Электронные учебники, НИО, Национальный институт образования, Сувит Александр">
        
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="css/switch.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-select.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/elib.js"></script>

    </head>
    <body>


<?php if($session->getRole()){ ?>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
            <ul class="nav navbar-nav">
                        <?php if($active == "index"){ $active_class = "active"; } else { $active_class = ""; } ?>
                        <li class="<?php echo $active_class; ?>"><a href="<?php echo $url; ?>index.php"><?php $lang->str('home') ?></a></li>
                        <?php if($active == "add"){ $active_class = "active"; } else { $active_class = ""; } ?>
                        <li class="<?php echo $active_class; ?>"><a href="<?php echo $url; ?>add.php"><?php $lang->str('add') ?></a></li>
                        <li class=""><a href="<?php echo $url; ?>?rebuildcat">Обновить ступени</a></li>
                        <?php if($active == "list"){ $active_class = "active"; } else { $active_class = ""; } ?>
                        <li class="<?php echo $active_class; ?>"><a href="booklist.php">Список учебников</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                    	<li><a href="<?php echo $url; ?>?logoff"><?php $lang->str('logoff') ?></a></li>
            </ul>
      </div>
    </nav>
<?php } ?>
<div class="container">
<?php if(!isset($_COOKIE['wmsg'])){ ?>
<div class="alert alert-success" style="text-align:center">
<a href="#" id="wmsg" class="close">&times;</a>
<b>Уважаемые посетители национального образовательного портала!<br>В настоящее время для скачивания электронных версий учебников рекомендуется использовать браузеры: Opera, Chrome, FireFox, IE11.</b>
</div>
<?php } ?>
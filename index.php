<?php 
$active = "index";

if(isset($_POST['wmsg'])){
	setcookie("wmsg", "1");
	exit;
}

if(isset($_GET['logoff'])){
	ob_start();
	session_start();
	unset($_SESSION['userid']);
	header("location: index.php");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['getbook'])){
  if (!isset($_POST['id'])) {header("location: index.php");exit;}
  if ($_POST['id'] == "" || !is_numeric($_POST['id'])) {header("location: index.php");exit;}
  $id = $_POST['id'];
  include_once 'includes/config.php';
  $mysqli = new mysqli($location, $username, $password, $database);
  $mysqli->set_charset("utf8");
  $query = $mysqli->prepare("SELECT
                                `books`.`path`,
                                `books`.`on`,
                                `books`.`dcount`
                           FROM 
                                `books` 
                           WHERE 
                                `id` = ?");
  $query->bind_param("i", $id);
  $query->bind_result($q_path, $q_on, $q_dcount);
  $query->execute();
  $query->fetch();
  $query->close();
  if ($q_on==0) {header("location: index.php");exit;}
  $file = "books/".$q_path;
  if (file_exists($file)) {
    $q_dcount++;
    $query = $mysqli->prepare("UPDATE `books` SET `dcount`=? WHERE `id`=?");
    $query->bind_param("ii", $q_dcount, $id);
    $query->execute();
    $query->close();
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
  }
  exit;
}

if (isset($_POST['getaddon'])){
  if (!isset($_POST['id'])) {header("location: index.php");exit;}
  if ($_POST['id'] == "" || !is_numeric($_POST['id'])) {header("location: index.php");exit;}
  $id = $_POST['id'];
  include_once 'includes/config.php';
  $mysqli = new mysqli($location, $username, $password, $database);
  $mysqli->set_charset("utf8");
  $query = $mysqli->prepare("SELECT
                                `books`.`addon`,
                                `books`.`on`
                           FROM 
                                `books` 
                           WHERE 
                                `id` = ?");
  $query->bind_param("i", $id);
  $query->bind_result($q_addon, $q_on);
  $query->execute();
  $query->fetch();
  $query->close();
  if ($q_on==0) {header("location: index.php");exit;}
  $file = "books/addons/".$q_addon;
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
  }
  exit;
}

if (isset($_POST['getfix'])){
  if (!isset($_POST['id'])) {header("location: index.php");exit;}
  if ($_POST['id'] == "" || !is_numeric($_POST['id'])) {header("location: index.php");exit;}
  $id = $_POST['id'];
  include_once 'includes/config.php';
  $mysqli = new mysqli($location, $username, $password, $database);
  $mysqli->set_charset("utf8");
  $query = $mysqli->prepare("SELECT
                                `books`.`path`,
                                `books`.`on`
                           FROM 
                                `books` 
                           WHERE 
                                `id` = ?");
  $query->bind_param("i", $id);
  $query->bind_result($q_path, $q_on);
  $query->execute();
  $query->fetch();
  $query->close();
  if ($q_on==0) {header("location: index.php");exit;}
  $fpath = pathinfo($q_path);
  $file = 'books/'.$fpath['dirname'].'/'.$fpath['filename'].'-fix.'.$fpath['extension'];
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
  }
  exit;
}

/////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

include_once 'includes/header.inc.php';

if(isset($_POST['loginsubmit'])){
	$username = $_POST['username'];
//	$password = md5($_POST['password']);
	$password = $_POST['password'];
	if ( ($username=="admin") and ($password=="123") ) {
		$_SESSION['userid'] = $username; 
		header("location: index.php");
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['mode'])) $mode = $_POST['mode']; else $mode = "none";
$fquery = "";
$fchar  = "";
$pagenav = 0;
$caption = "";

if($mode=="page"){
  $pagenav = $_POST['page-nav'];
  if(isset($_POST['char'])){
    if($_POST['char']<>"") $mode = "char";
  }
  if(isset($_POST['query'])) {
    if($_POST['query']<>"") $mode = "search";
  }
  if($mode<>"char" and $mode<>"search") $mode = "none";
}

if($mode=="char"){
  $q1 = $_POST['char']."%";
  $q2 = "@#$";
  $fchar = $_POST['char'];
  $caption = "на букву ".$_POST['char'];
}

if($mode=="search"){
  $fquery = $_POST['query'];
  $q1 = "%$fquery%";
  $q2 = $q1;
  $caption = "по запросу: $fquery";
}

if($mode=="none"){
  $q1 = "%";
  $q2 = "%";
}


 if(isset($_POST['category'])) $fcategory = $_POST['category']; else $fcategory = "%";
 if(isset($_POST['class'])) $fclass = $_POST['class']; else $fclass = "%";
 if(isset($_POST['year'])) $fyear = $_POST['year']; else $fyear = "%";
 if(isset($_POST['lang'])) $flang = $_POST['lang']; else $flang = "%";
 $filtered = ($fcategory<>"%" or $fclass<>"%" or $fyear<>"%" or $flang<>"%" or $mode=="char" or $mode=="search");

//check if there is a start
$limit = 10;
$start = $pagenav * $limit;

//count total records
$q_str = "SELECT COUNT(`id`) FROM `books` WHERE (`books`.`title` LIKE ? OR `books`.`authors` LIKE ?) AND `books`.`category` LIKE ? AND `books`.`class` LIKE ? AND `books`.`data` LIKE ? AND `books`.`lang` LIKE ?";
if($session->getRole() <> 1) $q_str .= " AND `on`=1";

$query_count = $mysqli->prepare($q_str);
$query_count->bind_param("ssssss", $q1, $q2, $fcategory, $fclass, $fyear, $flang);
$query_count->bind_result($total);
$query_count->execute();
$query_count->fetch();
$query_count->close();
//$total = $query_count->affected_rows;

?>
<div class="ovwlgd">
    <legend>Список учебников <?php echo $caption ?></legend>
</div>
<div class="ovwbtn">
    <ul class="pagination" style="margin:0px">
        <input id="search-box" type="text" class="form-control" placeholder="Поиск по названию и автору"
            style="width:340px;text-align:right;float:right;margin-right:5px">
</div>
<form id="mainform" class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" id="query" name="query" value="<?php echo $fquery ?>">
    <?php
if($total==0 and $q1=="%adminnio%"){ ?>
    <div class="alert alert-info">
        <input type="text" class="input-small" placeholder="Логин" name="username">
        <input type="password" class="input-small" placeholder="Пароль" name="password">
        <button type="submit" class="btn btn-default" name="loginsubmit">Войти</button>
    </div>
    <?php
include_once 'includes/footer.inc.php';
exit;
}

if(isset($_GET['rebuildcat'])){
  if($session->getRole()){
    $query = $mysqli->prepare("UPDATE `books` SET category=3 WHERE class <= 11");
    $query->execute();
    $query = $mysqli->prepare("UPDATE `books` SET category=2 WHERE class <= 9");
    $query->execute();
    $query = $mysqli->prepare("UPDATE `books` SET category=1 WHERE class <= 4");
    $query->execute();
    ?>
    <div class="alert alert-info">Ступени успешно обновлены</div>
    <?php
  }
}

// letters
?> <input type="hidden" id="char" name="char" value="<?php echo $fchar ?>">
    <center>
        <ul id="letters-panel" class="pagination"> <?php
      $query = $mysqli->prepare("SELECT SUBSTR(title,1,1) as `shorten` FROM `books` GROUP BY `shorten`");
      $query->bind_result($shorten);
      $query->execute();

      while($query->fetch()){
         if($shorten<>'') ?><li><a id="chr" href="" data-toggle="tooltip"
                    title="Вывести учебники на букву <?php echo $shorten; ?>"><?php echo $shorten; ?></a></li><?php
      }
      $query->close();
?> </ul>
    </center>
    <hr class="liniya">
    <div id="book"></div>
    <table id="booklist" class="table table-striped" style="border:1px solid;border-color:#cfcfcf">
        <tr id="filterrow">
            <?php if($session->getRole() == 1) echo "<th>Видимость</th><th style=\"text-align:center\">Скачан</th>"; ?>

            <th style="width:50px">
                <div data-toggle="tooltip" title="Отфильтровать по ступени обучения">
                    <select class="selectpicker form-control" id="category" name="category" title="Ступень"
                        data-header="Ступень" data-width="auto">
                        <option value="1" <?php if($fcategory==1) echo "selected" ?>>I (1-4кл.)</option>
                        <option value="2" <?php if($fcategory==2) echo "selected" ?>>II (5-9кл.)</option>
                        <option value="3" <?php if($fcategory==3) echo "selected" ?>>III (10-11кл.)</option>
                        <option value="" <?php if($fcategory=="%") echo "selected" ?> disabled style="display:none">
                        </option>
                    </select>
                </div>
            </th>

            <th style="width:50px;text-align:center">
                <div data-toggle="tooltip" title="Отфильтровать по классу обучения">
                    <select class="selectpicker form-control" id="class" name="class" title="Класс" data-header="Класс"
                        data-width="auto">
                        <?php for($i=0;$i<13;$i++){ echo "<option value=\"$i\"";if($i==$fclass) echo "selected";echo">$i</option>";} ?>
                        <option value="" <?php if($fclass=="%") echo "selected" ?> disabled style="display:none">
                        </option>
                    </select>
                </div>
            </th>

            <th style="width:50px;text-align:center">
                <div data-toggle="tooltip" title="Отфильтровать по году издания">
                    <select class="selectpicker form-control" id="year" name="year" title="Год" data-header="Год"
                        data-width="auto">
                        <?php
$query = $mysqli->prepare("SELECT `data` FROM `books` GROUP BY `data` ORDER BY `data`");
$query->bind_result($q_year);
$query->execute();
while($query->fetch()){
  echo "<option value=\5 "; if($q_year==$fyear) echo "selected"; echo ">5</option>";
}
?>
                        <option value="" <?php if($fyear=="%") echo "selected" ?> disabled style="display:none">
                        </option>
                    </select>
                </div>
            </th>

            <th style="width:50px">
                <div data-toggle="tooltip" title="Отфильтровать по языку обучения">
                    <select class="selectpicker form-control" id="lang" name="lang" title="Язык обучения"
                        data-header="Язык обучения" data-width="auto">
                        <option value="1" <?php if($flang==1) echo "selected" ?>>Русский</option>
                        <option value="2" <?php if($flang==2) echo "selected" ?>>Белорусский</option>
                        <option value="3" <?php if($flang==3) echo "selected" ?>>Русский и белорусский</option>
                        <option value="" <?php if($flang=="%") echo "selected" ?> disabled style="display:none">
                        </option>
                    </select>
                </div>
            </th>

            <th <?php if($filtered==0) echo "colspan=\"2\"" ?>><input type="text" class="form-control"
                    value="Названия учебников <?php echo $caption ?>" readonly
                    style="background-color:#fff;cursor:default">
            </th>

            <?php if($filtered==1){ ?>
            <th style="width:30px"><a href="" id="btn-clear" class="btn btn-default" style="" data-toggle="tooltip"
                    title="Очистить фильтр">X</a></th>
            <?php } ?>

        </tr>
        <tr id="captionrow">
            <th>Ступень</th>
            <th>Класс</th>
            <th>Год</th>
            <th>Язык обучения</th>
            <th colspan="2">Название</th>
        </tr>
        <?php

    $query_str = "SELECT 
                                    `books`.`id`, 
                                    `books`.`authors`, 
                                    `books`.`title`, 
                                    `books`.`data`, 
                                    `books`.`lang`, 
                                    `books`.`class`,
                                    `books`.`category`,
                                    `books`.`addon`,
				    `books`.`fix`,
                                    `books`.`on`,
                                    `books`.`dcount`
                               FROM 
                                    `books` 
                               WHERE ";
    if($session->getRole() <> 1) $query_str .= "`on`=1 AND ";
    $query_str .= "                (`books`.`title` LIKE ? OR
                                    `books`.`authors` LIKE ?) AND
                                    `books`.`category` LIKE ? AND
                                    `books`.`class` LIKE ? AND
                                    `books`.`data` LIKE ? AND
                                    `books`.`lang` LIKE ?
                               ORDER BY 
                                    `title` 
                               LIMIT 
                                    ?, ?";
    $query = $mysqli->prepare($query_str);
    $query->bind_param("ssssssii", $q1, $q2, $fcategory, $fclass, $fyear, $flang, $start, $limit);
    $query->bind_result($q_id, $q_authors, $q_title, $q_data, $q_lang, $q_class, $q_category, $q_addon, $q_fix, $q_on, $q_dcount);
    $query->execute();
    
    while($query->fetch()){
        ?>
        <tr book-id="<?php echo $q_id ?>">
            <?php if($session->getRole() == 1) {?>
            <td><input type="checkbox" id="on" class="cmn-toggle cmn-toggle-yes-no"
                    <?php if($q_on==1) echo "checked"; ?> onclick="return false"><label for="on" data-on="Да"
                    data-off="Нет"></label></td>
            <td style="text-align:center"><a href="<?php echo $url; ?>edit.php?id=<?php echo $q_id; ?>"
                    class="btn btn-primary"><?php echo $q_dcount; ?></a></td>
            <?php } ?>
            <td>
                <?php 
			if($q_category==1) echo "I (1-4кл.)";
			if($q_category==2) echo "II (5-9кл.)";
			if($q_category==3) echo "III (10-11кл.)";
		?>
            </td>
            <td align="center">
                <font size=+1><?php echo $q_class ?></font>
            </td>
            <td align="center"><?php echo $q_data ?></td>
            <td><?php if($q_lang==1) echo "Русский"; if($q_lang==2) echo "Белорусский"; if($q_lang==3) echo "Русский и белорусский"; ?>
            </td>
            <td colspan="2">
                <b><?php echo $q_title; if(trim($q_addon)!='') echo " <img src=\"cd.png\" data-toggle=\"tooltip\" title=\"имеется электронное приложение\">"; if($q_fix==1) echo " <img src=\"fix.png\" data-toggle=\"tooltip\" title=\"имеютя исправления\">";?></b><br><?php echo $q_authors; ?>
            </td>
        </tr>
        <?php
    }
    $query->close();
    ?>
    </table>

    <?php if($total<>0) {?>
    <div class="divcol" style="text-align:center">
        <input type="hidden" id="page-nav" name="page-nav" value="<?php echo $pagenav ?>">
        <ul class="pagination" style="margin:0px">

            <?php if($start != 0){ ?>
            <li><a id="btn-first" href="" class="prevnext" data-toggle="tooltip" title="В начало списка">|←</a></li>
            <li><a id="btn-prev" href="" class="prevnext">←</a></li>
            <?php } ?>
            <li><a href="" class="btnpage">
                    <?php
    echo ($start+1)."...";
    if($start+$limit <= $total) echo $start+$limit; else echo $total;
    echo " из $total";
  ?></a></li>
            <?php 
  if(($start + $limit) < $total ){ ?>
            <li><a id="btn-next" href="" class="prevnext">→</a></li>
            <li><a id="btn-last" href="" data-page="<?php echo floor($total/$limit) ?>" class="prevnext"
                    data-toggle="tooltip" title="В конец списка">→|</a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } else {?>
    <div class="alert alert-info">По вашему запросу/фильтру учебников не найдено. Удалите фильтр или измените критерии
        фильтрации.</div>
    <?php } ?>

    <input type="hidden" id="mode" name="mode" value="none">
</form>
<?php include_once 'includes/footer.inc.php'; ?>
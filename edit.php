<?php 
$active = "edit";
include_once 'includes/header.inc.php'; 

if(!$session->getRole() == 1) header("location: index.php");

$id = $_GET['id'];

if(isset($_POST['submit'])){
    $b_authors = $_POST['authors'];
    $b_title = $_POST['title'];
    $b_data = $_POST['data'];
    $b_lang = $_POST['lang'];
    $b_class = $_POST['class'];
    $b_path = $_POST['path'];
    $b_addon = $_POST['addon'];
    $b_note = $_POST['note'];
    if (isset($_POST['fix'])){$b_fix = $_POST['fix'];} else {$b_fix = 0;}
    if (isset($_POST['on'])){$b_on = $_POST['on'];} else {$b_on = 0;}

    if($b_title == ""){
        ?>
            <div class="alert alert-error">
                Необходимо ввести название книги
            </div>
        <?php
    } else {
        $query = $mysqli->prepare("UPDATE `books` SET `authors`= ?,`title`= ?,`data`= ?,`lang`= ?,`class`= ?,`path`= ?,`addon`= ?,`fix`= ?,`note`= ?,`on`= ? WHERE `id` = ?");
        $query->bind_param("sssiissisii", $b_authors, $b_title, $b_data, $b_lang, $b_class, $b_path, $b_addon, $b_fix, $b_note, $b_on, $id);
        $query->execute();
        $query->store_result();
        header("location: " . $url . "book.php?id=" . $id);
    }
}

$query = $mysqli->prepare("SELECT
                                `books`.`id`, 
                                `books`.`authors`, 
                                `books`.`title`, 
                                `books`.`data`, 
                                `books`.`lang`, 
                                `books`.`class`,
                                `books`.`path`,
                                `books`.`addon`,
				`books`.`fix`,
                                `books`.`note`,
                                `books`.`on`
                           FROM 
                                `books` 
                           WHERE 
                                `id` = ?");
$query->bind_param("i", $id);
$query->bind_result($q_id, $q_authors, $q_title, $q_data, $q_lang, $q_class, $q_path, $q_addon, $q_fix, $q_note, $q_on);
$query->execute();
$query->fetch();
$query->store_result();


?>

<legend>Изменение записи</legend>

<div class="divcol">
<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
  <fieldset>

  <table class="table table-striped">
  <tr>
	<th colspan="2">Детальная информация</th>
  </tr>

  <tr>
	<th>Путь к книге 
	<?php if(isset($_GET['selectpath'])){ ?>
	</td><td>
	<select class="selectpicker form-control" id="path" name="path">
	<?php foreach (glob("books/*/*") as $filename) {
		$filename = str_replace("books/","",$filename);
		echo "<option value=\"$filename\"";
		if($q_path==$filename) echo " selected";
		echo ">$filename</option>";} ?>
	</select>
	<?php } else { ?>
	<a href="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&selectpath' ?>" class="btn btn-default">Список</a></th>
	<td><input type="text" class="form-control" id="path" name="path" value="<?php echo $q_path ?>">
	<?php } ?>
	</td>

  <tr>
	<th>Дополнение 
	<?php if(isset($_GET['selectaddon'])){ ?>
	</td><td>
	<select class="selectpicker form-control" id="addon" name="addon">
	<option value="">нет</option>;
	<?php foreach (glob("books/addons/*") as $filename) {
		$filename = str_replace("books/addons/","",$filename);
		echo "<option value=\"$filename\"";
		if($q_path==$filename) echo " selected";
		echo ">$filename</option>";} ?>
	</select>
	<?php } else { ?>
	<a href="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&selectaddon' ?>" class="btn btn-default">Список</a></th>
	<td><input type="text" class="form-control" id="addon" name="addon" value="<?php echo $q_addon ?>">
	<?php } ?>
	</td>

  </tr>
  <tr>
	<th>Исправления</th>
	<td><input type="checkbox" class="cmn-toggle cmn-toggle-yes-no" id="fix" name="fix" <?php if($q_fix==1) echo "checked" ?> value="1">
	    <label for="fix" data-on="Да" data-off="Нет"></label>
	</td>
  </tr>
  <tr>
	<th width="20%">Примечание</th>
	<td><input type="text" class="form-control" id="note" name="note" value="<?php echo htmlspecialchars($q_note) ?>"></td>
  </tr>
  <tr>
	<th width="20%">Авторы книги</th>
	<td><input type="text" class="form-control" id="authors" name="authors" value="<?php echo $q_authors ?>"></td>
  </tr>
  <tr>
	<th>Название книги</th>
	<td><input type="text" class="form-control" id="title" name="title" value="<?php echo $q_title ?>"></td>
  </tr>
  <tr>
	<th>Год издания</th>
	<td><input type="text" class="form-control" id="data" name="data" value="<?php echo $q_data ?>"></td>
  </tr>
  <tr>
	<th>Язык обучения</th>
	<td>
	<select class="selectpicker form-control" id="lang" name="lang">
	<option value="1" <?php if($q_lang==1) echo "selected" ?>>Русский</option>
	<option value="2" <?php if($q_lang==2) echo "selected" ?>>Белорусский</option>
	<option value="3" <?php if($q_lang==3) echo "selected" ?>>Русский и белорусский</option>
	</select>
	</td>
  </tr>
  <tr>
	<th>Класс</th>
	<td>
	<select class="selectpicker form-control" id="class" name="class">
	<?php for($i=0;$i<13;$i++){ echo "<option value=\"$i\""; if($q_class==$i) echo "selected"; echo ">$i</option>";} ?>
	</select>
	</td>
  </tr>
  <tr>
	<th>Видимость</th>
	<td><input type="checkbox" class="cmn-toggle cmn-toggle-yes-no" id="on" name="on" <?php if($q_on==1) echo "checked" ?> value="1">
	    <label for="on" data-on="Да" data-off="Нет"></label>
	</td>
  </tr>
  </table>
            <a id="btn-closewindow" class="btn btn-default">Закрыть</a>
            <button type="submit" class="btn btn-primary btn-success" name="submit">Сохранить</button>
  </fieldset>
</form>
</div>
<?php include_once 'includes/footer.inc.php'; ?>
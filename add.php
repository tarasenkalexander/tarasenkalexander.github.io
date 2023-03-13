<?php 
$active = "add";
include_once 'includes/header.inc.php'; 

if(!$session->getRole() == 1) header("location: index.php");

if(isset($_POST['submit'])){
    $b_authors = $_POST['authors'];
    $b_title = $_POST['title'];
    $b_data = $_POST['data'];
    $b_lang = $_POST['lang'];
    $b_class = $_POST['class'];
    $b_path = $_POST['path'];
    if (isset($_POST['on'])){$b_on = $_POST['on'];} else {$b_on = 0;}

    if($b_title == ""){
        ?>
            <div class="alert alert-error">
                Необходимо ввести название книги
            </div>
        <?php
    } else {
        $query = $mysqli->prepare("INSERT INTO `books`
				(`authors`,`title`,`data`,`lang`,`class`,`path`,`on`) 
				VALUES(?,?,?,?,?,?,?)
				");
        $query->bind_param("sssiisi", $b_authors, $b_title, $b_data, $b_lang, $b_class, $b_path, $b_on);
        $query->execute();
        $query->store_result();
	if($query){
        ?>
            <div class="alert alert-success">Запись успешно добавлена</div>
        <?php
	} else {
        ?>
            <div class="alert alert-danger">Ошибка добавления записи.</div>
        <?php
	}
//        header("location: " . $url . "book.php?id=" . $id);
    }
}

?>

<legend>Добавление записи</legend>

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
	<?php
		$query = $mysqli->prepare("SELECT path FROM books");
		$query->bind_result($q_path);
		$query->execute();
		$allpath = "";
		while($query->fetch()){$allpath.=$q_path;}
		foreach (glob("books/*/*") as $filename) { 
			$filename = str_replace("books/","",$filename);
			if(strpos($allpath,$filename) === false) echo "<option value=\"$filename\">$filename</option>";
		}
	?>
	</select>
	<?php } else { ?>
	<a href="<?php echo $url; ?>add.php?selectpath=1" class="btn btn-default">Список</a></th>
	<td><input type="text" class="form-control" id="path" name="path" value="">
	<?php } ?>
	</td>
  </tr>
  <tr>
	<th width="20%">Авторы книги</th>
	<td><input type="text" class="form-control" id="authors" name="authors"></td>
  </tr>
  <tr>
	<th>Название книги</th>
	<td><input type="text" class="form-control" id="title" name="title"></td>
  </tr>
  <tr>
	<th>Год издания</th>
	<td><input type="text" class="form-control" id="data" name="data"></td>
  </tr>
  <tr>
	<th>Язык обучения</th>
	<td>
	<select class="selectpicker form-control" id="lang" name="lang">
	<option value="1">Русский</option>
	<option value="2">Белорусский</option>
	<option value="3">Русский и белорусский</option>
	</select>
	</td>
  </tr>
  <tr>
	<th>Класс</th>
	<td>
	<select class="selectpicker form-control" id="class" name="class">
	<?php for($i=0;$i<13;$i++){ echo "<option value=\"$i\">$i</option>";} ?>
	</select>
	</td>
  </tr>
  <tr>
	<th>Видимость</th>
	<td><input type="checkbox" class="cmn-toggle cmn-toggle-yes-no" id="on" name="on" value="1">
	    <label for="on" data-on="Да" data-off="Нет"></label>
	</td>
  </tr>
  </table>
	    <a href="<?php echo $url; ?>" class="btn btn-default"><?php $lang->str('cancel') ?></a>
            <button type="submit" class="btn btn-primary btn-success" name="submit">Добавить</button>
  </fieldset>
</form>
</div>
<?php include_once 'includes/footer.inc.php'; ?>
<?php 
$active = "book";
include_once 'includes/header.inc.php'; 


if (isset($_POST['getbook'])){
  if (!isset($_POST['id'])) {header("location: index.php");exit;}
  if ($_POST['id'] == "" || !is_numeric($_POST['id'])) {header("location: index.php");exit;}
  $id = $_POST['id'];
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
  $query->store_result();
  if ($q_on==0) {header("location: index.php");exit;}
  $file = "lib/".$q_path;
  if (file_exists($file)) {
    $q_dcount++;
    $query = $mysqli->prepare("UPDATE `books` SET `dcount`=? WHERE `id`=?");
    $query->bind_param("ii", $q_dcount, $id);
    $query->execute();
    $query->store_result();
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
    exit;
  }
}

if(!isset($_GET['id'])) {header("location: index.php");exit;}
if($_GET['id'] == "" || !is_numeric($_GET['id'])) {header("location: index.php");exit;}
$id = $_GET['id'];

$query = $mysqli->prepare("SELECT
                                `books`.`id`, 
                                `books`.`authors`, 
                                `books`.`title`,
                                `books`.`data`, 
                                `books`.`lang`, 
                                `books`.`class`,
                                `books`.`category`,
                                `books`.`path`,
                                `books`.`note`,
                                `books`.`on`
                           FROM 
                                `books` 
                           WHERE 
                                `id` = ?");
$query->bind_param("i", $id);
$query->bind_result($q_id, $q_authors, $q_title, $q_data, $q_lang, $q_class, $q_category, $q_path, $q_note, $q_on);
$query->execute();
$query->fetch();
$query->store_result();

if($q_on==0) {header("location: index.php");exit;}

?>

<legend><?php echo "$q_title" ?></legend>
<div class="divcol">
  <table class="table table-striped">
  <tr>
	<th colspan="2">Детальная информация</th>
  </tr>
  <tr>
	<th width="20%">Авторы книги</th>
	<td><?php echo $q_authors ?></td>
  </tr>
  <tr>
	<th>Год издания</th>
	<td><?php echo $q_data ?></td>
  </tr>
  <tr>
	<th>Язык обучения</th>
	<td>
	<?php 
	if($q_lang==1) echo "Русский";
	if($q_lang==2) echo "Белорусский";
	if($q_lang==3) echo "Русский и белорусский";
	?>
	</td>
  </tr>
  <tr>
	<th>Класс</th>
	<td><?php echo $q_class ?></td>
  </tr>
  <tr>
	<th>Уровень</th>
	<td>
	<?php 
	if($q_category==1) echo "I (1-4кл.)";
	if($q_category==2) echo "II (5-9кл.)";
	if($q_category==3) echo "III (10-11кл.)";
	?>
	</select>
	</td>
  </tr>
<? if(strlen($q_note) > 1){ ?>
  <tr>
	<th>Примечание</th>
	<td><?php echo $q_note; ?></td>
  </tr>
<? } ?>
  </table>

<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
  <fieldset>
	<input type="hidden" name="id" value="<?php echo $q_id ?>">
	<button type="submit" class="btn btn-primary" name="getbook">Скачать книгу</button>
	<?php if($session->getRole() == 1) {?>
	<a href="<?php echo $url; ?>edit.php?id=<?php echo $q_id; ?>" class="btn btn-default">Редактировать</a>
	<?php } ?>
  </fieldset>
</form>
</div>
<?php include_once 'includes/footer.inc.php'; ?>
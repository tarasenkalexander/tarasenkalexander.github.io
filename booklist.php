<?php
$active = "list";
include_once 'includes/header.inc.php'; 

if(!$session->getRole() == 1) header("location: index.php");
?>

<div style="text-align: center">
<a href="?all" class="btn btn-default">URL-список всех книг</a>
<a href="?active" class="btn btn-default">URL-список включенных книг</a>
<a href="?nall" class="btn btn-default">Список всех книг</a>
<a href="?nactive" class="btn btn-default">Список включенных книг</a>
</div>
<br>

<?php
if(isset($_GET['all']) or isset($_GET['active'])){
echo '<div style="text-align: center"><b>';
if(isset($_GET['all'])) echo "URL-список всех книг";
else echo "URL-список включенных книг";
echo '</b></div><br><div>';
$query_str = 'SELECT `path` FROM `books`';
if(isset($_GET['active'])) $query_str .= ' WHERE `on`=1 ';
$query_str .= 'ORDER BY `title`';
$query = $mysqli->prepare($query_str);
$query->bind_result($q_path);
$query->execute();
    
while($query->fetch()){
  echo 'http://e-padruchnik.adu.by/books/'.$q_path.'<br>';
}

echo '</div></body></html>';
exit;
}


if(isset($_GET['nall']) or isset($_GET['nactive'])){
echo '<div style="text-align: center"><b>';
if(isset($_GET['nall'])) echo "Список всех книг";
else echo "Список включенных книг";
echo '</b></div><br><div>';
$query_str = 'SELECT `class`,`data`,`title`,`authors` FROM `books`';
if(isset($_GET['nactive'])) $query_str .= ' WHERE `on`=1 ';
$query_str .= 'ORDER BY `title`,`class`';
$query = $mysqli->prepare($query_str);
$query->bind_result($q_class,$q_data,$q_title,$q_authors);
$query->execute();
    
while($query->fetch()){
  echo $q_class.'кл. - '.$q_data.' - <b>'.$q_title.'</b> - '.$q_authors.'<br>';
}

echo '</div></body></html>';
exit;
}

?>



    <table class="table table-striped" style="border:1px solid;border-color:#cfcfcf">
        <tr id="captionrow"><th>Видимость</th><th>Ступень</th><th>Класс</th><th>Год</th><th>Язык обучения</th><th colspan="2">Название</th></tr>
    <?php

    $query_str = "SELECT 
                                    `books`.`id`, 
                                    `books`.`authors`, 
                                    `books`.`title`, 
                                    `books`.`data`, 
                                    `books`.`lang`, 
                                    `books`.`class`,
                                    `books`.`category`,
                                    `books`.`on`,
                                    `books`.`dcount`,
                                    `books`.`path`
                               FROM 
                                    `books` 
                               ORDER BY 
                                    `title`";
    $query = $mysqli->prepare($query_str);
    $query->bind_result($q_id, $q_authors, $q_title, $q_data, $q_lang, $q_class, $q_category, $q_on, $q_dcount, $_path);
    $query->execute();
    
    while($query->fetch()){
        ?>
        <tr book-id="<?php echo $q_id ?>">
            <td><input type="checkbox" id="on" class="cmn-toggle cmn-toggle-yes-no" <?php if($q_on==1) echo "checked"; ?> onclick="return false"><label for="on" data-on="Да" data-off="Нет"></label></td>
            <td width=130>
		<?php 
			if($q_category==1) echo "I (1-4кл.)";
			if($q_category==2) echo "II (5-9кл.)";
			if($q_category==3) echo "III (10-11кл.)";
		?>
	    </td>
            <td align="center"><font size=+1><?php echo $q_class ?></font></td>
	    <td align="center"><?php echo $q_data ?></td>
	    <td><?php if($q_lang==1) echo "Русский"; if($q_lang==2) echo "Белорусский"; if($q_lang==3) echo "Русский и белорусский"; ?></td>
            <td><b><?php echo $q_title; ?></b> - <?php echo $q_authors; ?></td>
            <td><a href="/books/<?php echo $_path?>" class="btn btn-default">Скачать</a></td>
        </tr>
        <?php
    }
    $query->store_result();
    ?>
    </table>
</body>
</html>
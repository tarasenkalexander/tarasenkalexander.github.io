<?php
class lang{

function str($outstr){

$lang_str['fname'] = 'Фамилия';
$lang_str['sname'] = 'Имя Отчество';
$lang_str['teacher'] = 'Учитель';
$lang_str['regn'] = 'Регион';
$lang_str['uo'] = 'Учреждение образования';
$lang_str['email'] = 'e-mail';
$lang_str['login'] = 'Логин';
$lang_str['pass'] = 'Пароль';
$lang_str['kurs'] = 'Курсы';
$lang_str['added'] = 'Добавлен';
$lang_str['modified'] = 'Изменен';


// меню
$lang_str['home'] = 'Главная';
$lang_str['users'] = 'Пользователи';
$lang_str['add'] = 'Добавить';
$lang_str['settings'] = 'Настройки';
$lang_str['logoff'] = 'Выйти';

$lang_str['edituser'] = 'Изменение профиля';
$lang_str['adduser'] = 'Добавить пользователя';




$lang_str['userlist'] = 'Список пользователей';

$lang_str['newuserlist'] = 'Список новых пользователей';


// details
$lang_str['dview'] = 'Детальная информация: ';
$lang_str['synced'] = 'Синхронизировано ';


//buttons
$lang_str['login'] = 'Логин';
$lang_str['yes'] = 'Да';
$lang_str['no'] = 'Нет';
$lang_str['ok'] = 'Ок';
$lang_str['edit'] = 'Изменить';
$lang_str['save'] = 'Сохранить';
$lang_str['delete'] = 'Удалить';
$lang_str['cancel'] = 'Отмена';
$lang_str['addmdl'] = 'Добавить в Moodle';
$lang_str['openmdl'] = 'Открыть в Moodle';
$lang_str['addcat'] = 'Подключить к разделу';
$lang_str['sync'] = 'Синхронизировать';
$lang_str['email'] = 'Email';
$lang_str['preview'] = 'Предпросмотр';

$lang_str[''] = '';

echo $lang_str[$outstr];
}

function getRegion($regn){
  switch ($regn) {
    case 1:
        $uregn = "Брестская обл.";
	break;
    case 2:
        $uregn = "Витебская обл.";
	break;
    case 3:
        $uregn = "Гомельская обл.";
	break;
    case 4:
        $uregn = "Гродненская обл.";
	break;
    case 5:
        $uregn = "Минская обл.";
	break;
    case 6:
        $uregn = "Могилевская обл.";
	break;
    case 7:
        $uregn = "г.Минск";
	break;
  }
  return $uregn;
}

}
?>

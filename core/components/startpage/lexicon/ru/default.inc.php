<?php
if (!isset($_lang)) {
    $_lang = [];
}
include_once 'setting.inc.php';

$_lang['startpage'] = 'Startpage';
$_lang['sp_menu_desc'] = 'Управление домашней страницей';

$_lang['provider_facebook'] = 'Facebook';
$_lang['provider_google'] = 'Google';
$_lang['provider_twitter'] = 'Twitter';
$_lang['provider_vkontakte'] = 'Вконтакте';
$_lang['provider_yandex'] = 'Яндекс';

$_lang['title_add_link'] = 'Добавление ссылки';
$_lang['title_edit_profile'] = 'Изменение профиля';

$_lang['err_auth_get'] = 'Пожалуйста, войдите на сайт с помощью одной из соцсетей';
$_lang['err_auth_remove'] = 'Вы должны быть авторизованы для удаления ссылок';
$_lang['err_auth_add'] = 'Вы должны быть авторизованы для добавления своих ссылок';
$_lang['err_auth_update'] = 'Вы должны быть авторизованы для обновления ссылок';
$_lang['err_auth_profile'] = 'Вы должны быть авторизованы для редактирования профиля';

$_lang['err_link_ns'] = 'Вы забыли указать ссылку';
$_lang['err_link_wrong'] = 'Неправильный формат ссылки';
$_lang['err_link_nf'] = 'Сайт по ссылке не отвечает';
$_lang['err_link_ae'] = 'Вы уже добавили эту ссылку';
$_lang['err_link_update'] = 'Не могу обновить ссылку';

$_lang['err_city_ns'] = 'Вы забыли указать город';
$_lang['err_city_nf'] = 'Такого города нет в списке. Пожалуйста, напишите об этом на info@webstartpage.ru';

$_lang['err_profile_name'] = 'Вы забыли указать своё имя';
$_lang['err_profile_image'] = 'Не могу загрузить картинку по ссылке';

$_lang['success_link_add'] = 'Ваша ссылка успешно добавлена';
$_lang['success_link_update'] = 'Ссылка успешно обновлена';
$_lang['success_profile'] = 'Настройки успешно сохранены';
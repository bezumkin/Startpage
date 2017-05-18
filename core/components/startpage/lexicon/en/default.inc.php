<?php
if (!isset($_lang)) {
    $_lang = [];
}
include_once 'setting.inc.php';

$_lang['startpage'] = 'Startpage';
$_lang['sp_menu_desc'] = 'The management of start page';

$_lang['provider_facebook'] = 'Facebook';
$_lang['provider_google'] = 'Google';
$_lang['provider_twitter'] = 'Twitter';
$_lang['provider_vkontakte'] = 'Vkontakte';
$_lang['provider_yandex'] = 'Yandex';

$_lang['title_add_link'] = 'Add a new link';
$_lang['title_edit_profile'] = 'Change profile';

$_lang['err_auth_get'] = 'Please login via one of social networks';
$_lang['err_auth_remove'] = 'You must be authenticated to remove links';
$_lang['err_auth_add'] = 'You must be authenticated to save your links';
$_lang['err_auth_update'] = 'You must be authenticated to update links';
$_lang['err_auth_profile'] = 'You must be authenticated to edit your profile';

$_lang['err_link_ns'] = 'You forgot to specify the link';
$_lang['err_link_wrong'] = 'Invalid link';
$_lang['err_link_nf'] = 'Site not responding';
$_lang['err_link_ae'] = 'You have already added this link';
$_lang['err_link_update'] = 'Could not update link';

$_lang['err_city_ns'] = 'You forgot to specify the city';
$_lang['err_city_nf'] = 'This city is not in the list. Please, email to info@webstartpage.ru about it';

$_lang['err_profile_name'] = 'You forgot to enter your name';
$_lang['err_profile_image'] = 'Could not load image by link';

$_lang['success_link_add'] = 'Your link has been successfully added';
$_lang['success_link_update'] = 'Link was successfully updated';
$_lang['success_profile'] = 'Settings saved successfully';

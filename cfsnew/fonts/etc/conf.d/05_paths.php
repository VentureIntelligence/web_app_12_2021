<?php

define('MAIN_APP_DIR',MAIN_PATH.APP_NAME.'/');//new path
define('MAIN_LIB_DIR',MAIN_APP_DIR.'libs/');
define('MAIN_PUBLIC_DIR',MAIN_APP_DIR."www/");
define('MAIN_WRAPPER_LIB_DIR',MAIN_APP_DIR.'libs/wrappers/');
define('MAIN_WORK_DIR',MAIN_APP_DIR."work/");
define('MAIN_LOG_DIR',MAIN_APP_DIR.'logs/');

define('ADMIN_DIR',WEB_ADMIN_DIR);
define('ADMIN_IMG_DIR',ADMIN_DIR.'images/');
define('ADMIN_CSS_DIR',ADMIN_DIR.'css/');
define('ADMIN_JS_DIR',ADMIN_DIR.'js/');

define('WEB_IMG_DIR',WEB_DIR.'images/');
define('WEB_CSS_DIR',WEB_DIR.'css/');
define('WEB_JS_DIR',WEB_DIR.'js/');

define('WEB_CSS_PATH',MAIN_PUBLIC_DIR.'css/');
define('WEB_JS_PATH',MAIN_PUBLIC_DIR.'js/');

define('MEDIA_DIR',MAIN_APP_DIR.'media/');
define('MEDIA_IMG_DIR',MEDIA_DIR.'img/');


/************************
* Modules configuration *
*************************/
define('MODULES_DIR',MAIN_APP_DIR.'modules/');
define('FLAG_MODULES_DIR',MAIN_APP_DIR.'modules/flagArrays/');
define('APP_MODULES_DIR',MAIN_APP_DIR.'modules/app/');


/************************
* Images Path configuration *
*************************/
define('IMAGE_DIR',MAIN_APP_DIR.'media/img/');
define('IMAGE_T_ALBUM_DIR',IMAGE_DIR.'t_album/');
define('IMAGE_ALBUM_DIR',IMAGE_DIR.'album/');
define('IMAGE_PROFILE_DIR',IMAGE_DIR.'profiles/');


define('TEMPLATES_DIR',MAIN_APP_DIR.'templates/templates/');

?>

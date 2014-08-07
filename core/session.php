<?php
require_once __DIR__."/config/config.php";
function my_session_start($timeout = 600)
{
    ini_set('session.gc_maxlifetime', $timeout);
    ini_set('session.cookie_path', APP_NAME);
	date_default_timezone_set('Asia/Kolkata');
    session_start();
    if (isset($_SESSION['timeout_idle']) && $_SESSION['timeout_idle'] < time()) {
        session_destroy();
        session_start();
        session_regenerate_id();
        $_SESSION = array();
    }
    $_SESSION['timeout_idle'] = time() + $timeout;
	require_once __DIR__."/vendor/autoload.php";
}
?>
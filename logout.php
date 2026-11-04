<?php
session_start();
$_SESSION = [];

// Hapus cookie session & cookie remember me
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
setcookie('remember_username', '', time() - 3600, '/');
session_destroy();

header('Location: index.php?pesan=logout');
exit;

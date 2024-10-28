<?php
session_start();
session_unset();
session_destroy();

// Remover o cookie
setcookie("user_token", "", time() - 3600, "/");

// Redirecionar para a página de login
header("Location: login.html");
exit();
?>
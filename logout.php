<?php
// Запуск сеанса
session_start();

// Уничтожение всех сеансов и данных сеанса
session_destroy();

// Перенаправление на страницу входа
header("Location: login.php");
exit;
?>

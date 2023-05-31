<?php
$host = 'localhost'; // Хост базы данных
$db = 'SALON'; // Имя базы данных
$user = 'newuser1'; // Пользователь базы данных
$password = 'password'; // Пароль базы данных

// Устанавливаем соединение с базой данных
$conn = new mysqli($host, $user, $password, $db);

// Проверяем соединение на наличие ошибок
if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}
?>

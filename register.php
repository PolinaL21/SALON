<?php
include 'config.php';

// Проверяем, была ли отправлена форма регистрации
if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Проверяем совпадение паролей
    if ($password != $confirm_password) {
        echo "<script>alert('Пароли не совпадают')</script>";;
    } else {
        // Проверяем, существует ли телефон в базе данных
        $existing_user_query = "SELECT * FROM users WHERE phone = '$phone'";
        $existing_user_result = $conn->query($existing_user_query);
        if ($existing_user_result->num_rows > 0) {
            echo "<script>alert('Телефон уже зарегистрирован.')</script>";
        } else {
            // Хэшируем пароль
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Вставляем данные пользователя в таблицу
            $status = 'client'; // Статус пользователя по умолчанию
            $insert_query = "INSERT INTO users (first_name, last_name, phone, password, status) VALUES ('$first_name', '$last_name', '$phone', '$hashed_password', '$status')";
            if ($conn->query($insert_query) === TRUE) {
                echo "<script>alert('Вы зарегистрированы!')</script>";
            } else {
                echo "<script>alert('Ошибка при регистрации! Попробуйте снова')</script>"; $conn->error;
            }
        }
    }
}
?>
<html>
<head>
</head>
<body>
<img class="center" src="princess.png" width=20%;>
<form method="post" action="register.php">
    <input type="text" placeholder="Имя" name="first_name" required>
    <br>
    <input type="text" placeholder="Фамилия" name="last_name" required>
    <br>
    <input type="text" placeholder="Телефон" name="phone" required>
    <br>
    <input type="password" placeholder="Пароль" name="password" required>
    <br>
    <input type="password" placeholder="Подтвердите Пароль" name="confirm_password" required>
    <br>
    <input type="submit" name="register" value="Зарегистрироваться">
</form>
<div class="container signin">
 
    <p><strong>Уже есть аккаунт?</strong> <a href="login.php">Войти</a></p>
  </div>

</body>
</html>
<style>
body{
	background: #fcf0f9;
}
input[type=submit]{
  background-color: #ff6392;
  color: black;
  padding: 16px 20px;
  border-radius: 15px;
  margin: 8px 0;
  border: 3px solid black;
  cursor: pointer;
  width: 100%;
  width: 600px;
  opacity: 0.9;
}
.container {
  padding: 16px;
}
.signin {
  background-color: #fcf0f9;
  text-align: center;
  color:black;
}
A {
    color: black; /* Цвет обычной ссылки */
   }
A:visited {
    color: black; /* Цвет посещенной ссылки */
   }
input[type=text], input[type=password],input[type=date],input[type=time] {
  width: 100%;
  padding: 15px;
  text-align: center;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: 2px solid black;
  background: #fff5f8;
  border-radius: 15px;
  width: 600px;
  box-sizing: border-box;
  margin-right: auto;
  margin-left: auto;
}

form {
	background: #fcf0f9;
	padding: auto;
	color: white;
	margin-right: auto;
	margin-left: auto;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
	
}
</style>
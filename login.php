<?php
include 'config.php';

// Проверяем, была ли отправлена форма входа
if (isset($_POST['login'])) {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Получаем данные пользователя из базы данных по телефону
    $sql = "SELECT * FROM users WHERE phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Проверяем соответствие пароля
        if (password_verify($password, $row['password'])) {
            // Пароль верный, устанавливаем сессию для пользователя
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['status'] = $row['status'];

            // Перенаправляем пользователя на соответствующую страницу в зависимости от статуса
            if ($row['status'] == 'master') {
                header("Location: master.php");
            } elseif ($row['status'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: client.php");
            }
            exit();
        } else {
            echo "<script>alert('Неверный номер телефона или пароль')</script>";$conn->error;
        }
    } else {
        echo "<script>alert('Неверный номер телефона или пароль')</script>";$conn->error;
    }
}
?>

<p><img class="center" src="princess.png" width=20%></p>
<form method="post" action="login.php">
    <input type="text" placeholder="Телефон" name="phone" required><br>
    <input type="password" placeholder="Пароль" name="password" required><br>
    <input type="submit" name="login" value="Войти">
</form>

<div class="container signin">
    <p><strong>Нет аккаунта?</strong> <a href="register.php">Зарегистрируйтесь</a></p>
  </div>
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
A {
    color: black; /* Цвет обычной ссылки */
   }
A:visited {
    color: black; /* Цвет посещенной ссылки */
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
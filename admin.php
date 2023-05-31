<?php
session_start();
include 'config.php';

// Проверяем, является ли пользователь авторизованным и имеет ли статус "админ"
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'admin') {
header("Location: login.php");
exit();
}

// Проверяем, была ли отправлена форма регистрации
if (isset($_POST['register'])) {
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// Проверяем, есть ли уже пользователь с таким номером телефона
$existing_user_sql = "SELECT * FROM users WHERE phone = '$phone'";
$existing_user_result = $conn->query($existing_user_sql);

if ($existing_user_result->num_rows > 0) {
echo "<script>alert('Телефон уже зарегистрирован!')</script>";
} else {
// Хэшируем пароль
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Вставляем данные пользователя в таблицу
$status = 'client'; // Статус пользователя по умолчанию
$insert_user_sql = "INSERT INTO users (first_name, last_name, phone, password, status) VALUES ('$first_name', '$last_name', '$phone', '$hashed_password', '$status')";
if ($conn->query($insert_user_sql) === TRUE) {
echo "<script>alert('Пользователь добавлен!')</script>";
} else {
echo "<script>alert('Ошибка при добавлении пользователя!')</script>"; $conn->error;
}
}
}
?>
<div class="sidenav">
 <a href="admin.php"><img  class="center" src="home.png" width=75px height=75px><a>
  <br>
  <a href="requests.php"><img  class="center" src="db.png" width=65px height=70px></a>
  <br>
  <a href="add_note.php"><img  class="center" src="pometka.png" width=70px height=70px></a>
  <br>
  <a href="clients_list.php"><img  class="center" src="klienty.png" width=70px height=75px></a>
  <a href="logout.php"><img  class="ex" src="exit.png" width=75px height=75px></a>
</div>
<div class="main">
<h2>Добавить пользователя</h2>
<hr>
<form method="POST" action="">
    <input type="text" placeholder="Имя" name="first_name" required><br>
    <input type="text" placeholder="Фамилия" name="last_name" required><br>
    <input type="text" placeholder="Телефон" name="phone" required><br>
    <input type="password" placeholder="Пароль" name="password" required><br>

    <input type="submit" name="register" value="Добавить Пользователя">
</form>
</div>
<style>
h2 {
text-align: center
}
hr {
  border: 1px solid #ffb8eb;
  margin-bottom: 25px;
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
   .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.sidenav {
  height: 100%; /* Полная высота: удалите это, если вы хотите "авто" высота */
  width: 100px; /* Установите ширину боковой панели */
  position: fixed; /* Фиксированная боковая панель (оставайтесь на месте при прокрутке) */
  z-index: 1;
  top: 0; 
  left: 0;
  background-color: #fac5ef;
  overflow-x: hidden; 
  padding-top: 20px;
}
.ex{
	position: absolute;
        top: 610px;
        right: center;
}
.main {
  margin-left: 100px; /* То же, что и ширина боковой панели */
  padding: 0px 10px;
}

</style>
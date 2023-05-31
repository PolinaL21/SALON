<?php
session_start();
include 'config.php';

// Проверяем, является ли пользователь авторизованным
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'client') {
    header("Location: login.php");
    exit();
}

// Получаем список мастеров из таблицы users со статусом "master"
$sql = "SELECT * FROM users WHERE status = 'master'";
$master_result = $conn->query($sql);

// Получаем список услуг из таблицы services
$sql = "SELECT * FROM services";
$services_result = $conn->query($sql);

// Проверяем, была ли отправлена форма подачи заявки
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $service = $_POST['service'];
    $master_id = $_POST['master'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Вставляем данные заявки в таблицу applications
    $sql = "INSERT INTO applications (user_id, service, master_id, date, time) VALUES ('$user_id', '$service', '$master_id', '$date', '$time')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Вы записаны!')</script>";
    } else {
        echo "<script>alert('Ошибка!')</script>";  $conn->error;
    }
}
?>


<div class="sidenav">
  <a href="client.php"><img  class="center" src="home.png" width=75px height=75px><a>
  <br>
  <a href="my_applications.php"><img  class="center" src="db.png" width=65px height=70px></a>
  <a href="logout.php"><img  class="ex" src="exit.png" width=75px height=75px></a>
</div>
<div class="main">
<h2>Запись на услугу</h2><hr>
<form method="post" action="client.php">
    <label>Услуга:</label><br>
    <select name="service" placeholder="Выберите услугу:" required>
        <?php while ($row = $services_result->fetch_assoc()) { ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php } ?>
    </select><br><br>

    <label>Мастер:</label><br>
    <select name="master" required>
        <?php while ($row = $master_result->fetch_assoc()) { ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
        <?php } ?>
    </select><br><br>

    <label>Дата услуги:</label><br>
    <input type="date"  name="date" required><br>

    <label>Время услуги:</label><br>
    <input type="time" name="time" min="10:00" max="22:00" required><br>

    <input type="submit" name="submit" value="Записаться">
</form>
</div>

<style>

select {
    width: 600px; /* Ширина списка в пикселах */
	height:50px;
    border:2px solid #000000;
   }
label{
text-align: center
}
 
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

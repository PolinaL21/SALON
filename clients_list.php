<?php
session_start();
include 'config.php';

// Проверяем, является ли пользователь авторизованным и имеет ли статус "админ"
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Получаем список клиентов
$sql = "SELECT * FROM users WHERE status = 'client'";
$client_result = $conn->query($sql);
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
<a href="clients_list.php"><button>Клиенты</button></a>
<a href="masters_list.php"><button>Мастера</button></a>
<hr>
<table>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Телефон</th>
        <th>Пометка</th>
    </tr>
    <?php while ($row = $client_result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['note']; ?></td>
        </tr>
    <?php } ?>
</table>

</div>


<style>
button{
    background-color: #ff6392;
  color: black;
  padding: 16px 20px;
  border-radius: 15px;
  margin: 8px 0;
  border: 2px solid black;
  cursor: pointer;
  width: 45%;
  width: 250px;
  opacity: 0.9;
  display: inline-block;
  font-size : 16px;
}
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #ffb8eb;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

  
	h2 {
text-align: center
}
hr {
  border: 1px solid #ffb8eb;
  margin-bottom: 25px;
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

<?php
session_start();
include 'config.php';

// Проверяем, является ли пользователь авторизованным и имеет ли статус "админ"
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Определение параметров сортировки
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'id'; // По умолчанию сортируем по ID
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Получаем список заявок с сортировкой
$sql = "SELECT applications.id, applications.service, CONCAT(users.first_name, ' ', users.last_name) AS client_name, applications.master_id, applications.date, applications.time, applications.status FROM applications INNER JOIN users ON applications.user_id = users.id ORDER BY $sort_column $sort_order";

$result = $conn->query($sql);
?>
<div class="sidenav">
    <a href="admin.php"><img class="center" src="home.png" width=75px height=75px><a>
    <br>
    <a href="requests.php"><img class="center" src="db.png" width=65px height=70px></a>
    <br>
    <a href="add_note.php"><img class="center" src="pometka.png" width=70px height=70px></a>
    <br>
    <a href="clients_list.php"><img class="center" src="klienty.png" width=70px height=75px></a>
    <a href="logout.php"><img class="ex" src="exit.png" width=75px height=75px></a>
</div>

<div class="main">
    <h2>Список заявок</h2>
    <hr>
    <table>
        <tr>
            <th><a href="?sort=id&order=<?php echo $sort_column === 'id' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">ID</a></th>
            <th><a href="?sort=service&order=<?php echo $sort_column === 'service' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Услуга</a></th>
            <th><a href="?sort=user_id&order=<?php echo $sort_column === 'user_id' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Клиент</a></th>
            <th><a href="?sort=master_id&order=<?php echo $sort_column === 'master_id' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Мастер</a></th>
            <th><a href="?sort=date&order=<?php echo $sort_column === 'date' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Дата</a></th>
            <th><a href="?sort=time&order=<?php echo $sort_column === 'time' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Время</a></th>
            <th>Статус</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['service']; ?></td>
                <td><?php echo $row['client_name']; ?></td>

                <td><?php echo $row['master_id']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<style>
    
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

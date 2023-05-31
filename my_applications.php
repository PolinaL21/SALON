<?php
session_start();
include 'config.php';

// Проверяем, является ли пользователь авторизованным
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Получаем имя клиента из таблицы users
$sql = "SELECT first_name FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$client_name = $result->fetch_assoc()['first_name'];

// Определение параметров сортировки
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'date'; // По умолчанию сортируем по дате
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Получаем список заявок текущего пользователя с сортировкой
$sql = "SELECT applications.id, applications.service, CONCAT(users.first_name, ' ', users.last_name) AS master_name, applications.date, applications.time, applications.status
        FROM applications 
        INNER JOIN users ON applications.master_id = users.id 
        WHERE applications.user_id = '$user_id'
        ORDER BY $sort_column $sort_order";
$result = $conn->query($sql);
?>
<div class="sidenav">
  <a href="client.php"><img class="center" src="home.png" width=75px height=75px><a>
  <br>
  <a href="my_applications.php"><img class="center" src="db.png" width=65px height=70px></a>
  <a href="logout.php"><img class="ex" src="exit.png" width=75px height=75px></a>
</div>
<div class="main">
    <h2>Мои заявки</h2>
    <hr>
    <p>Клиент: <?php echo $client_name; ?></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Услуга</th>
            <th>Мастер</th>
            <th><a href="?sort=date&order=<?php echo $sort_column === 'date' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Дата</a></th>
            <th><a href="?sort=time&order=<?php echo $sort_column === 'time' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Время</a></th>
            <th>Статус</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['service']; ?></td>
                <td><?php echo $row['master_name']; ?></td>
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
<?php
session_start();
include 'config.php';

// Проверяем, является ли пользователь авторизованным и имеет ли статус "мастер"
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'master') {
    header("Location: login.php");
    exit();
}

$master_id = $_SESSION['user_id'];

// Определение параметров сортировки
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'date'; // По умолчанию сортируем по дате
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Получаем список заявок, связанных с данным мастером, с сортировкой
$sql = "SELECT applications.id, applications.service, CONCAT(users.first_name, ' ', users.last_name) AS client_name, applications.date, applications.time, applications.status 
        FROM applications 
        INNER JOIN users ON applications.user_id = users.id 
        WHERE applications.master_id = '$master_id'
        ORDER BY $sort_column $sort_order";

$result = $conn->query($sql);

// Обработка обновления статуса заявки
if (isset($_POST['update_status'])) {
    $application_id = $_POST['application_id'];
    $new_status = $_POST['new_status'];

    // Обновляем статус заявки в таблице applications
    $update_sql = "UPDATE applications SET status = '$new_status' WHERE id = '$application_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Статус заявки обновлен!')</script>";$conn->error;
    } else {
        echo "<script>alert('Ошибка')</script>";$conn->error;
    }
}
?>

<div class="sidenav">
  <a href="master.php"><img class="center" src="db.png" width=65px height=70px></a>
  <a href="logout.php"><img class="ex" src="exit.png" width=75px height=75px></a>
</div>
<div class="main">
    <h2>Список заявок</h2>
    <hr>
    <table>
        <tr>
            <th>ID</th>
            <th>Услуга</th>
            <th>Клиент</th>
            <th><a href="?sort=date&order=<?php echo $sort_column === 'date' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Дата</a></th>
            <th><a href="?sort=time&order=<?php echo $sort_column === 'time' && $sort_order === 'ASC' ? 'desc' : 'asc'; ?>">Время</a></th>
            <th>Статус</th>
            <th>Обновить статус</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['service']; ?></td>
                <td><?php echo $row['client_name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                        <select name="new_status">
                            <option value="текущее">Текущее</option>
                            <option value="выполнено">Выполнено</option>
                            <option value="отклонено">Отклонить</option>
                        </select>
                        <input type="submit" name="update_status" value="Обновить">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<style>
    h2 {
        text-align: center
    }
hr {
  border: 1px solid #ffb8eb;
  margin-bottom: 25px;
}
    table {
        width: 100%;
        border-collapse: collapse;
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

    select {
        padding: 5px;
    }

    input[type="submit"] {
        padding: 5px 10px;
        background-color: #ff6392;
        color: #000000;
        cursor: pointer;padding: 16px 20px;
  border-radius: 15px;
  margin: 8px 0;
  border: 2px solid black;
  cursor: pointer;
  width: 100%;
  width: 100px;
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
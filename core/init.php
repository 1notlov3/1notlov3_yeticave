<?php
// $host = 'localhost';
// $dbname = 'bar';
// $username = 'root';
// $pass = '';
// $charset = 'utf8mb4';
// $collate = 'utf8mb4_0900_ai_ci';
// $driver = 'mysql';

require_once('core/helpers.php');


$db = (require_once('core/config.php'))['db'];

$dsn = "{$db['driver']}:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db['charset']} COLLATE {$db['collate']}"
];

try {
    $con = new PDO($dsn, $db['username'], $db['password'], $options);
} catch(PDOException $e) {
    die("Подключение к серверу MySQL не удалось - {$e->getMessage()}");
}

$categories = $con->query('SELECT * FROM categories')->fetchAll();

$title = "Главная";

session_start();
$is_auth = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? "";

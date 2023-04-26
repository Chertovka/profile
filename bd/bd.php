<?php
$config = include 'config.php';

$conn = new mysqli($config['DBSERVER'], $config['DBUSER'], $config['DBPASSWORD']);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = 'CREATE DATABASE"' . $config['DATABASE'] . '""';
if ($conn->query($sql) === TRUE) {
    echo "База данных создана успешно";
}

$conn->close();

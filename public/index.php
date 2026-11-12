<?php
require_once __DIR__ . '/../src/functions.php';

$day = date('d.m.Y');
$version = '1.0.0';
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Заявки сотрудников — ТРПО практика 4</title>
</head>
<body>
  <main>
    <h1>Заявки сотрудников</h1>
    <p> Версия приложения: <?= $version?></p>
    <p> Сегодня: <?= $day?></p>
  </main>
</body>
</html>

<?php
require_once dirname(__FILE__) . '/../src/functions.php';

$day = date('d.m.Y');
$version = '1.0.0'; 
$departments = ['Разработка', 'Аналитика', 'Тестирование', 'Поддержка'];

$csvPath = dirname(__FILE__) . '/../data/employees.csv';
$employees = loadEmployees($csvPath);
$employeesCount = count($employees);

$showEmails = true;
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Заявки сотрудников. Практика 4</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <h1>Заявки сотрудников</h1>
    <p> Версия приложения: <?= $version?></p>
    <p> Сегодня: <?= $day?></p>
    <p>Сотрудников в файле: <?= e((string) $employeesCount) ?></p>
    <p>Показывать email: <?= $showEmails ? 'да' : 'нет' ?></p>
    <p>Отделы: <?=e(implode(', ', $departments)) ?></p>

    <h2>Сотрудники</h2>
    <table class="employees">
      <thead>
        <tr>
          <th>ID</th>
          <th>ФИО</th>
          <th>Отдел</th>
          <th>Опыт</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($employees as $employee): ?>
          <tr>
            <td><?= e((string) $employee['id']) ?></td>
            <td><?= e($employee['name']) ?></td>
            <td><?= e($employee['department']) ?></td>
            <td><?= e((string) $employee['experience']) ?></td>
            <td>
              <?php if ($showEmails): ?>
                <?= e($employee['email']) ?>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>

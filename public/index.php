<?php
require_once dirname(__FILE__) . '/../src/functions.php';

$day = date('d.m.Y');
$version = '1.0.0'; 
$departments = ['Разработка', 'Аналитика', 'Тестирование', 'Поддержка'];

$csvPath = dirname(__FILE__) . '/../data/employees.csv';
$employeesFromFile = loadEmployees($csvPath);
$filterDepartment = trim($_GET['department'] ?? '');
$employees = filterEmployeesByDepartment($employeesFromFile, $filterDepartment);
$employeesCount = count($employees);

$showEmails = true;

$name = trim($_POST['name'] ?? '');
$department = trim($_POST['department'] ?? '');
$experience = trim($_POST['experience'] ?? '');
$email = trim($_POST['email'] ?? '');

$isSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$errors = [];
$success = false;
if ($isSubmitted) {
    $errors = validateApplication(
        [
            'name' => $name,
            'department' => $department,
            'experience' => $experience,
            'email' => $email,
        ],
        $departments
    );
    $success = $errors === [];
}

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

    <form method="get" action="">
      <label>Фильтр по отделу
        <select name="department">
          <option value="">Все</option>
          <?php foreach ($departments as $dep): ?>
            <option value="<?= e($dep) ?>"<?= $filterDepartment === $dep ? ' selected' : '' ?>><?= e($dep) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <button type="submit">Показать</button>
    </form>

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

<h2>Новая заявка</h2>
<?php if ($success): ?>
  <p>Заявка принята: <?= e($name) ?>, <?= e($department) ?>, опыт <?= e($experience) ?>, <?= e($email) ?></p>
<?php endif; ?>
<?php if ($errors !== []): ?>
  <ul>
    <?php foreach ($errors as $message): ?>
      <li><?= e($message) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<form method="post" action="">
  <p>
    <label>ФИО
      <input type="text" name="name" value="<?= e($name) ?>">
    </label>
  </p>
  <p>
    <label>Отдел
      <select name="department">
        <option value="">— выберите —</option>
        <?php foreach ($departments as $dep): ?>
          <option value="<?= e($dep) ?>"<?= $department === $dep ? ' selected' : '' ?>><?= e($dep) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </p>
  <p>
    <label>Опыт (лет)
      <input type="number" name="experience" value="<?= e($experience) ?>">
    </label>
  </p>
  <p>
    <label>Email
      <input type="email" name="email" value="<?= e($email) ?>">
    </label>
  </p>
  <p>
    <button type="submit">Отправить</button>
  </p>
</form>
</body>
</html>

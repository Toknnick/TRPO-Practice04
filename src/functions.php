<?php

function mapEmployeeRow(array $row): array
{
    return [
        'id' => (int) $row[0],
        'name' => $row[1],
        'department' => $row[2],
        'experience' => (int) $row[3],
        'email' => $row[4],
    ];
}

function loadEmployees(string $csvPath): array
{
    $employees = [];
    $file = fopen($csvPath, 'r');

    //Отбросить заголовок 
    fgetcsv($file, 0, ';');

    while (($row = fgetcsv($file, 0, ';')) != false){
        $employees[] = mapEmployeeRow($row);
    }

    return $employees;
}


function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function validateApplication(array $data, array $departments): array
{
    $errors = [];

    $name = $data['name'];
    $department = $data['department'];
    $experience = $data['experience'];
    $email = $data['email'];

    if ($name === '') {
        $errors['name'] = 'Укажите ФИО';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'ФИО слишком короткое';
    } elseif (strlen($name) > 100) {
        $errors['name'] = 'ФИО слишком длинное';
    }

    if ($department === '' || !in_array($department, $departments, true)) {
        $errors['department'] = 'Выберите отдел';
    }

    if ($experience === '' || !is_numeric($experience)) {
        $errors['experience'] = 'Укажите опыт числом';
    } else {
        $experienceNum = (int) $experience;
        if ($experienceNum < 0 || $experienceNum > 100) {
            $errors['experience'] = 'Опыт должен быть от 0 до 100';
        }
    }

    if ($email === '') {
        $errors['email'] = 'Укажите email';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Некорректный email';
    }

    return $errors;
}

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

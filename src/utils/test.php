<?php
function sql_insert(string $table, array $data)
{

    $columns = array_keys($data);
    $placeholders = array_fill(0, count($data), '?');

    $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ")
            VALUES (" . implode(',', $placeholders) . ")";
    echo $sql;
    print_r(array_values($data));
}


sql_insert('USERS', ["username" => "kevin", "email" => "keviiiin"]);

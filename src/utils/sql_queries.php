<?php

require_once __DIR__ . "/../db.php";

function sql_insert(string $table, array $data)
{
    $pdo = getPDO();

    $columns = array_keys($data);
    $placeholders = array_fill(0, count($data), '?');

    $sql = "INSERT INTO `$table` (" . implode(',', $columns) . ")
            VALUES (" . implode(',', $placeholders) . ")";

    $query = $pdo->prepare($sql);
    return $query->execute(array_values($data));
}


function sql_exists(string $table, array $data)
{
    $pdo = getPDO();

    $columns = array_keys($data);
    $conditions = [];
    foreach ($columns as $col) {
        $conditions[] = "$col = ?";
    }

    $sql = "SELECT 1 FROM `$table`
            WHERE " . implode(" OR ", $conditions) . "
            LIMIT 1";

    $query = $pdo->prepare($sql);
    $query->execute(array_values($data));
    return (bool) $query->fetchColumn();
}

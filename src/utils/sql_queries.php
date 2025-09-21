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

function sql_update(string $table, array $data, string $key, string $value)
{
    $pdo = getPDO();

    $columns = array_keys($data);
    $conditions = [];
    foreach ($columns as $col) {
        $conditions[] = "`$col` = ?";
    }

    $sql = "UPDATE `$table`
        SET " . implode(", ", $conditions) .
        " WHERE `$key` = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array_merge(array_values($data), [$value]));
}

function sql_exists(string $table, array $data, ?string $condition = "OR")
{
    $pdo = getPDO();

    $columns = array_keys($data);
    $conditions = [];
    foreach ($columns as $col) {
        $conditions[] = "$col = ?";
    }

    $sql = "SELECT 1 FROM `$table`
            WHERE " . implode(" " . $condition . " ", $conditions) .
        " LIMIT 1";

    $query = $pdo->prepare($sql);
    $query->execute(array_values($data));
    return (bool) $query->fetchColumn();
}

function sql_select(string $table, array $conditions, ?string $toSelect = '*')
{
    $pdo = getPDO();

    $conditions = [];
    foreach (array_keys($conditions) as $key) {
        $conditions[] = "`$key` = ?";
    }

    $sql = "SELECT $toSelect FROM `$table` WHERE " . implode(' OR ', $conditions);

    $query = $pdo->prepare($sql);
    $query->execute(array_values($conditions));

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

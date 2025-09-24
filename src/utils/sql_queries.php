<?php

require_once __DIR__ . '/../bootstrap.php';

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
    $rhs = [];
    foreach ($columns as $col) {
        $rhs[] = "`$col` = ?";
    }

    $sql = "UPDATE `$table`
        SET " . implode(", ", $rhs) .
        " WHERE `$key` = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array_merge(array_values($data), [$value]));
}

function sql_exists(string $table, array $data, ?string $condition = "OR", ?string $extend = '')
{
    $pdo = getPDO();

    $columns = array_keys($data);
    $rhs = [];
    foreach ($columns as $col) {
        $rhs[] = "$col = ?";
    }

    $sql = "SELECT 1 FROM `$table`
            WHERE " . implode(" " . $condition . " ", $rhs) .
        " " . $extend . " " .
        " LIMIT 1";

    $query = $pdo->prepare($sql);
    $query->execute(array_values($data));
    return (bool) $query->fetchColumn();
}

function sql_select(string $table, array $data, ?string $toSelect = '*', ?string $condition = "AND")
{
    $pdo = getPDO();

    $rhs = [];
    foreach (array_keys($data) as $key) {
        $rhs[] = "`$key` = ?";
    }

    $sql = "SELECT $toSelect FROM `$table` WHERE " . implode(' ' . $condition . ' ', $rhs);
    $query = $pdo->prepare($sql);
    $query->execute(array_values($data));

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function sql_delete(string $table, array $data, ?string $condition = "OR")
{
    $pdo = getPDO();

    $columns = array_keys($data);
    $rhs = [];
    foreach ($columns as $col) {
        $rhs[] = "$col = ?";
    }

    $sql = "DELETE FROM `$table`
            WHERE " . implode(" " . $condition . " ", $rhs);
    $query = $pdo->prepare($sql);
    $query->execute(array_values($data));
}

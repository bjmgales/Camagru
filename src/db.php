<?php


function getPDO(): PDO
{
    $dsn = "mysql:host=database;dbname=" . getenv('MYSQL_DATABASE');
    $user = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');

    try {
        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("❌ Database connection failed: " . $e->getMessage());
    }
}

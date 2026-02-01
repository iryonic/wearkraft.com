<?php
require_once 'config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

/**
 * Procedural Database Helpers
 */

function db_query($sql, $params = []) {
    global $conn;
    $stmt = mysqli_prepare($conn, $sql);
    if ($params) {
        $types = "";
        foreach ($params as $param) {
            if (is_int($param)) $types .= "i";
            elseif (is_double($param)) $types .= "d";
            else $types .= "s";
        }
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function db_fetch_all($sql, $params = []) {
    $result = db_query($sql, $params);
    if (!$result) return [];
    
    if (function_exists('mysqli_fetch_all')) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function db_fetch_one($sql, $params = []) {
    $result = db_query($sql, $params);
    if (!$result) return null;
    return mysqli_fetch_assoc($result);
}

function db_insert_id() {
    global $conn;
    return mysqli_insert_id($conn);
}

function db_escape($string) {
    global $conn;
    return mysqli_real_escape_string($conn, $string);
}
?>

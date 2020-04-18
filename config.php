<?php

try {
    $db = new PDO(
        'mysql:dbname=bank;host=localhost',
        'root',
        ''
    );
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
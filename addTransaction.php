<?php
session_start();

require 'config.php';

if(isset($_POST['value']) && !empty($_POST['value'])) {
    $type = $_POST['type'];
    $value = str_replace(",", ".", $_POST['value']);
    $id = $_SESSION['bank'];

    $sql = $db->prepare(
        "INSERT INTO historic (account_id, type, value, date)
         VALUES (:account_id, :type, :value, NOW())
        ");
    $sql->bindValue(":account_id", $id);
    $sql->bindValue(":type", $type);
    $sql->bindValue(":value", $value);
    $sql->execute();

    if($type == '0') {
        $sql = $db->query(
            "UPDATE accounts SET 
            balance= balance + '$value' WHERE id='$id'"
        );
    } else {
        $sql = $db->query(
            "UPDATE accounts SET 
            balance= balance - '$value' WHERE id='$id'"
        );
    }

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyAccount</title>
</head>
<body>
    <form method="post">
        <label for="type">Transaction type</label>
        <select name="type">
            <option value="0">Deposit</option>
            <option value="1">Withdraw</option>
        </select>
        <br/>
        <label for="value">Value</label>
        <input type="text" pattern="[0-9.,]{1,}" name="value"/>

        <button type="submit">Send</button>
    </form>
</body>
</html>
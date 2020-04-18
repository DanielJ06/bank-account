<?php
session_start();
require 'config.php';

if(isset($_POST['password']) && !empty($_POST['password'])) {
    $agency = addslashes($_POST['agency']);
    $account = addslashes($_POST['account']);
    $password = md5(addslashes($_POST['password']));

    $sql = $db->query(
        "SELECT * FROM accounts WHERE agency='$agency' AND account='$account' AND password='$password'"
    );
    
    if($sql->rowCount() > 0) {
        $sql = $sql->fetch();

        $_SESSION['bank'] = $sql['id'];
        header("Location: index.php");
        exit;
    } else {
        echo "<p>Something wrong, please try again</p>";
    }
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
    <h1>Login</h1>
    <form method="post">
        <label for="agency">Agency:</label>
        <input type="text" name="agency"/>
        <br/>
        <label for="account">Account:</label>
        <input type="text" name="account"/>
        <br/>
        <label for="account">Password:</label>
        <input type="text" name="password"/>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
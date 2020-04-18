<?php
session_start();
require 'config.php';

if(isset($_SESSION['bank']) && !empty($_SESSION['bank'])) {
    $id = $_SESSION['bank'];
    $sql = $db->query("SELECT * FROM accounts WHERE id='$id'");
    $response = $sql->fetch();
} else {
    header("Location: login.php");
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
    <h1>Bank name</h1>
    <p>Holder: <?php echo $response['holder'] ;?></p>
    <p>Agency: <?php echo $response['agency'] ;?></p>
    <p>Account: <?php echo $response['account'] ;?></p>
    <p>
        Balance: <?php echo number_format($response['balance'], '2', ',', '.') ;?>
    </p>
    <a href="quit.php">Logout</a> -
    <a href="addTransaction.php">Add new transaction</a>
    <hr>
    <table>
        <tr>
            <th>Date</th>
            <th>Value</th>
        </tr>
        <?php 
            $sql = $db->query("SELECT * FROM historic WHERE account_id='$id'");
            if($sql->rowCount() > 0) {
                foreach($sql->fetchAll() as $transaction) {
                    echo "<tr>";
                    echo "<td>". date('d/m/Y H:i', strtotime($transaction['date'])) ."</td>";
                    if($transaction['type'] == '0') {
                        echo "<td><font color='green'>".number_format($transaction['value'], '2', ',', '.')."+</font></td>";
                    } else {
                        echo "<td><font color='red'>".number_format($transaction['value'], '2', ',', '.')."-</font></td>";
                    } 
                    echo "</tr>";
                }
            }            
        ?>
    </table>
</body>
</html>
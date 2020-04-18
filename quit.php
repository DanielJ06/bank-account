<?php
session_start();

unset($_SESSION['bank']);
header("Location: index.php");
exit;
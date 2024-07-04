<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $_SESSION['remainingBudget'] -= $amount;
}

header("Location: spend.php");
exit();
?>

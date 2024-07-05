<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $monthlyBudget = $_POST['monthly-budget'];
    $_SESSION['monthlyBudget'] = $monthlyBudget;
    $_SESSION['remainingBudget'] = $monthlyBudget;
}

header("Location: spend.php");
exit();
?>

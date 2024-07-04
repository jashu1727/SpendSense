<?php
session_start();
if (!isset($_SESSION['monthlyBudget']) || !isset($_SESSION['remainingBudget'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendSense - Track Spending</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Track Your Spending</h1>
        <p>Monthly Budget: ₹<?php echo $_SESSION['monthlyBudget']; ?></p>
        <p>Remaining Budget: ₹<?php echo $_SESSION['remainingBudget']; ?></p>
        <form id="spend-form" action="update_budget.php" method="post">
            <label for="amount">Enter Amount:</label>
            <input type="number" id="amount" name="amount" required>
            <label for="purpose">Purpose:</label>
            <select id="purpose" name="purpose" required>
                <option value="groceries">Groceries</option>
                <option value="entertainment">Entertainment</option>
                <option value="bills">Bills</option>
                <option value="other">Other</option>
            </select>
            <button type="submit">Add Expense</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('spend-form');
            const remainingBudgetDisplay = document.querySelector('p:nth-of-type(2)');
            let remainingBudget = parseFloat(<?php echo $_SESSION['remainingBudget']; ?>);

            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Prevent the form from submitting the traditional way

                const amount = parseFloat(document.getElementById('amount').value);

                if (!isNaN(amount) && amount > 0) {
                    remainingBudget -= amount;
                    remainingBudgetDisplay.textContent = `Remaining Budget: ₹${remainingBudget.toFixed(2)}`;

                    // Optionally, update the session server-side
                    fetch('update_budget.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `amount=${amount}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Server response:', data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

                    form.reset(); // Reset the form after submission
                } else {
                    alert('Please enter a valid amount.');
                }
            });
        });
    </script>
</body>
</html>

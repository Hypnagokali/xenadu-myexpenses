<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyExpenses - Input</title>
</head>
<body>
    <h1>MyExpenses</h1>
    <?php echo "<p>User ID: " . $_SESSION['uid'] . "</p>"; ?>
    <form method="POST" action="wuff">
        <input type="number" name="costs" value="10"/>
        <input type="submit" name="submit">
    </form>
</body>
</html>
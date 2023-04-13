<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskmaster - Dashboard</title>
    <!-- Anda dapat menambahkan CSS dan JavaScript di sini jika diperlukan -->
</head>
<body>
    <h1>Welcome to Taskmaster, <?php echo $_SESSION['user']['nama']; ?></h1>
    <p>You are now logged in.</p>
    <a href="index.php?action=logout">Logout</a>
</body>
</html>

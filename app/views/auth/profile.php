<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskmaster - Profile</title>
    <!-- Anda dapat menambahkan CSS dan JavaScript di sini jika diperlukan -->
</head>
<body>
    <h1>Profile</h1>
    <p>Username: <?php echo $_SESSION['user']['nama']; ?></p>
    <p>Email: <?php echo $_SESSION['user']['email']; ?></p>

    <a href="index.php?action=edit_profile">Edit Profile</a>
    <a href="index.php?action=delete_account">Delete Account</a>
</body>
</html>

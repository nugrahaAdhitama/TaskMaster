<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Taskmaster</title>
    <!-- Anda dapat menambahkan CSS dan JavaScript di sini jika diperlukan -->
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="index.php?action=edit_profile_process" method="post">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo $_SESSION['user']['nama']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $_SESSION['user']['email']; ?>"><br><br>
        <input type="submit" value="Save">
    </form>
    <a href="index.php?action=profile">Back to Profile</a>
</body>
</html>

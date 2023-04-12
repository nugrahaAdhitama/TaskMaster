<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskmaster - Register</title>
    <!-- Anda dapat menambahkan CSS dan JavaScript di sini jika diperlukan -->
</head>
<body>
    <h1>Register</h1>
    <form action="index.php?action=register_process" method="post">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskmaster - Delete Account</title>
    <!-- Anda dapat menambahkan CSS dan JavaScript di sini jika diperlukan -->
</head>
<body>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account?</p>

    <form action="index.php?action=delete_account_process" method="post">
        <button type="submit" name="submit" value="yes">Yes</button>
        <button type="submit" name="submit" value="no">No</button>
    </form>
</body>
</html>

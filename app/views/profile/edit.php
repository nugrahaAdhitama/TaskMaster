    <h1>Edit Profile</h1>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $_SESSION['user']['email']; ?>" disabled><br><br>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?= $_SESSION['user']['nama']; ?>"><br><br>
        <label for="nama">Password Baru:</label>
        <input type="password" name="password" id="password"><br><br>
        <input type="submit" name="submit" value="Save">
    </form>
    <a href="./">Back to Profile</a>
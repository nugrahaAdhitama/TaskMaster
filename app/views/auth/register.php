    <h1>Register</h1>
    <form action="" method="post">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required autofocus>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" id="submit" name="submit">Register</button>
    </form>
    <br>
    <a href="<?= BASE_URI ?>">Back to Home</a>
    <h1>Profile</h1>
    <p>Username: <?php echo $_SESSION['user']['nama']; ?></p>
    <p>Email: <?php echo $_SESSION['user']['email']; ?></p>

    <a href="<?= BASE_URI ?>dashboard">Back to Dashboard</a>
    <a href="<?= BASE_URI ?>profile/edit">Edit Profile</a>
    <a href="<?= BASE_URI ?>profile/delete">Delete Account</a>
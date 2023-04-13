    <h1>Profile</h1>
    <p>Username: <?php echo $_SESSION['user']['nama']; ?></p>
    <p>Email: <?php echo $_SESSION['user']['email']; ?></p>

    <a href="index.php?action=edit_profile">Edit Profile</a>
    <a href="index.php?action=delete_account">Delete Account</a>
    <a href="index.php?action=dashboard">Back to Dashboard</a>
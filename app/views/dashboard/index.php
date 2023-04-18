    <h1>Welcome to Taskmaster, <?= $_SESSION['user']['nama'] ?></h1>
    <p>You are now logged in.</p>
    <a href="<?= BASE_URI ?>auth/logout">Logout</a>
    <a href="<?= BASE_URI ?>profile">Profile</a>
    <a href="<?= BASE_URI ?>schedule">Schedule</a>
    <a href="<?= BASE_URI ?>task">Task</a>
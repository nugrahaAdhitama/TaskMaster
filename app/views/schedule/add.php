<h1>Add Schedule</h1>

<form action="" method="post">
    <label for="course">Course:</label>
    <input type="text" name="course" required autofocus><br><br>
    <label for="course">Started at:</label>
    <input type="text" name="started_at" required><br><br>
    <label for="course">Ended at:</label>
    <input type="text" name="ended_at" required><br><br>
    <label for="course">Day:</label>
    <input type="text" name="day" required><br><br>
    <label for="course">Room:</label>
    <input type="text" name="room" required><br><br>
    <label for="course">Notes:</label>
    <input type="text" name="notes"><br><br>
    <button type="submit" name="submit">Add</button>
</form>

<a href="<?= BASE_URI ?>schedule">Back to Schedule</a>
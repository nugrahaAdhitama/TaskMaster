<h1>Add Schedule</h1>

<form action="" method="post">
    <label for="course">Course:</label>
    <input type="text" name="course" id="course" required autofocus><br><br>
    <label for="started_at">Started at:</label>
    <input type="text" name="started_at" id="started_at" required><br><br>
    <label for="ended_at">Ended at:</label>
    <input type="text" name="ended_at" id="ended_at" required><br><br>
    <label for="day">Day:</label>
    <input type="text" name="day" id="day" required><br><br>
    <label for="room">Room:</label>
    <input type="text" name="room" id="room" required><br><br>
    <label for="notes">Notes:</label>
    <input type="text" name="notes" id="notes"><br><br>
    <button type="submit" name="submit">Add</button>
</form>

<a href="<?= BASE_URI ?>schedule">Back to Schedule</a>